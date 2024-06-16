<?php

/** @var $model QuestionDecisionForm */
/** @var $territoryId int */

use app\models\forms\QuestionDecisionForm;
use app\models\forms\QuestionForm;
use app\models\work\AgesIntervalWork;
use yii\helpers\Html;
use yii\jui\SliderInput;
use yii\widgets\ActiveForm;
?>

<style>
    .scene {
        height: 600px;
    }
    .scene canvas {
        border-radius: 15px;
    }
</style>

<div class="back-block">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'decision')->dropDownList([1 => 'Вариант 1', 2 => 'Вариант 2', 3 => 'Вариант 3'])->label('Выберите наиболее понравившийся вариант') ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Подтвердить выбор', ['class' => 'btn btn-success', 'name' => 'decision-button', 'style' => 'width: 100%']) ?>
        </div>
    </div>
</div>


<div class="territories">
    <div class="base-weights scene-block">
        <h2>Вариант 1</h2>
        <div id="v1" style="display: none;">
            <?= var_dump($model->territoires[0]->getDataForScene($territoryId)) ?>
        </div>
        <div id="scene-container-1" class="scene"></div>
    </div>
    <div class="change-weights scene-block">
        <h2>Вариант 2</h2>
        <div id="v2" style="display: none;">
            <?= var_dump($model->territoires[1]->getDataForScene($territoryId)) ?>
        </div>
        <div id="scene-container-2" class="scene"></div>
    </div>
    <div class="votes scene-block">
        <h2>Вариант 3</h2>
        <div id="v3" style="display: none;">
            <?= var_dump($model->territoires[2]->getDataForScene($territoryId)) ?>
        </div>
        <div id="scene-container-3" class="scene"></div>
    </div>
</div>


<style>
    .back-block {
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 30px;
        margin-top: 10px;
        background-color: #f5f5f5;
        padding-bottom: 5px;
    }

    .scene-block {
        border-radius: 15px;
        background-color: #88b6f4;
        padding: 10px;
        margin-bottom: 15px;
    }

    h2 {
        font-family: "Nunito", sans-serif;
        font-size: 30px;
    }
</style>


<?php ActiveForm::end() ?>

<script src="https://cdn.jsdelivr.net/npm/three@0.130.1/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.130.1/examples/js/loaders/GLTFLoader.js"></script>
<script>
    // Объявили переменные для работы с тремя сценами
    const scenes = [];
    const cameras = [];
    const sceneContainers = [];
    const renderers = [];
    const drift = 0.5;
    var isRotateCameras = [false, false, false];
    var degreeCameras = [0, 0, 0];
    var previousMouseX = [0, 0, 0];
    var id;
    var gridSizeX, gridSizeY, gridSizeZ;

    // Инициализировали создание сцен и добавление триггеров
    for (let i = 0; i < 3; i++) {
        const scene = new THREE.Scene();
        scene.background = new THREE.Color('#F0F8FF');
        scenes.push(scene);

        const sceneContainer = document.getElementById(`scene-container-${i+1}`);
        sceneContainers.push(sceneContainer);

        const camera = new THREE.PerspectiveCamera(75, sceneContainer.clientWidth / sceneContainer.clientHeight, 1, 1000);
        camera.position.z = 10;
        camera.position.y = -5;
        camera.rotation.x = 0.5;
        cameras.push(camera);

        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(sceneContainer.clientWidth, sceneContainer.clientHeight);
        sceneContainer.appendChild(renderer.domElement);

        sceneContainer.addEventListener('mousedown', onMouseDown, false);
        sceneContainer.addEventListener('mouseup', onMouseUp, false);
        sceneContainer.addEventListener('wheel', zoom, false);
        renderers.push(renderer);

        var date = document.getElementById(`v${i+1}`).innerText;
        init(date, scene, camera);
    }

    // Отрисовываем сетку и объекты на ней
    function init(date, scene, camera) {
        var dateObj = JSON.parse(date.substring(date.indexOf('{'), date.lastIndexOf('}}}') + 3));
        var gridMesh = new THREE.Group();

        gridSizeX = dateObj.result.matrixCount.width + 1;
        gridSizeY = dateObj.result.matrixCount.height + 1;
        gridSizeZ = dateObj.result.matrixCount.maxHeight + 10;

        var gridColor = new THREE.Color('#808080');

        var edgesMaterial = new THREE.LineBasicMaterial({ color: 0x000000 });
        var driftCellX = gridSizeX % 2 == 0 ? 0 : drift;
        var driftCellY = gridSizeY % 2 == 0 ? 0 : drift;

        // Тут сетка пола
        for (let i = 0; i < gridSizeX * gridSizeY; i++) {
            var cellGeometry = new THREE.BoxBufferGeometry(1, 1, 0.01);
            var cellMaterial = new THREE.MeshBasicMaterial({ color: gridColor, transparent: true, opacity: 0.5, side: THREE.DoubleSide });
            var cell = new THREE.Mesh(cellGeometry, cellMaterial);
            var edges = new THREE.LineSegments(new THREE.EdgesGeometry(cellGeometry), edgesMaterial);
            cell.position.set(i % gridSizeX - gridSizeX / 2 + driftCellX, Math.floor(i / gridSizeX) - gridSizeY / 2 + driftCellY, 0);
            gridMesh.add(cell);
            cell.add(edges);
        }

        scene.add(gridMesh);
        camera.position.set(0, -(gridSizeY / 2), gridSizeZ);
        const loader = new THREE.GLTFLoader();

        // Тут загрузка моделей
        for (let i = 0; i < dateObj.result.objects.length; i++) {
            (function (index) {
                var rotation = dateObj.result.objects[index].rotate === 0 ? 0 : Math.PI / 2;
                var rotateX = (dateObj.result.objects[index].length % 2 === 0) ? drift : 0;
                var rotateY = (dateObj.result.objects[index].width % 2 === 0) ? drift : 0;

                if (rotation !== 0) {
                    var temp = rotateX;
                    rotateX = rotateY;
                    rotateY = temp;
                }

                const randomColor = Math.floor(Math.random() * 16777215).toString(16);
                var material = new THREE.MeshBasicMaterial({color: parseInt(randomColor, 16)});

                if (!dateObj.result.objects[index].link)
                {
                    dateObj.result.objects[index].link = 'models/0.glb';
                }

                loader.load(
                    dateObj.result.objects[index].link,
                    function (gltf) {
                        const model = gltf.scene;
                        // Найдем все материалы модели и установим для них текстуры
                        model.traverse((child) => {
                            if (child.isMesh) {
                                if (child.material.map)
                                {
                                    material = new THREE.MeshBasicMaterial({ map: child.material.map });
                                }
                                child.material = material;
                            }
                        });
                        //model.scale.set(dateObj.result.objects[index].length, dateObj.result.objects[index].width, dateObj.result.objects[index].height);
                        model.scale.set(1, 1, 1);
                        model.rotation.z = rotation;
                        model.position.set(dateObj.result.objects[index].dotCenter.x + rotateX, dateObj.result.objects[index].dotCenter.y + rotateY, 0);

                        // Добавляем модель в сцену
                        scene.add(model);
                    },
                    undefined,
                    function (error) {
                        // Если модель отсутствует, то заменяем её на примитивный полигон (параллелепипед)
                        const geometry = new THREE.BoxGeometry(dateObj.result.objects[index].length, dateObj.result.objects[index].width, dateObj.result.objects[index].height);
                        const oneObject = new THREE.Mesh(geometry, material);

                        oneObject.position.set(dateObj.result.objects[index].dotCenter.x + rotateX, dateObj.result.objects[index].dotCenter.y + rotateY, 0.5);
                        oneObject.rotation.z = rotation;
                        scene.add(oneObject);
                        console.error('Error loading 3D model', error);
                    }
                );
            })(i);
        }
    }

    // Направление курсора по оси ОХ
    function directionX(event)
    {
        var currentMouseX = event.clientX;
        var direction = 1;

        if (currentMouseX < previousMouseX[id]) {
            direction *=  -1;
        }

        previousMouseX[id] = currentMouseX;
        return direction;
    }

    // Изменяем угол поворота
    function whereGoCamera(event)
    {
        degreeCameras[id] += 90 * directionX(event);
    }

    // Обновляем данные позиции и поворота камеры
    function updateCamera()
    {
        if (Math.abs(degreeCameras[id]) === 360 || degreeCameras[id] === 0)
        {
            degreeCameras[id] = 0;
            cameras[id].position.set(0, -(gridSizeY / 2), gridSizeZ);
            cameras[id].rotation.set(0.5, 0, 0);
        }
        else if (degreeCameras[id] === 90 || degreeCameras[id] === -270)
        {
            cameras[id].position.set(-(gridSizeX / 2), 0, gridSizeZ);
            cameras[id].rotation.set(0, -0.5, -Math.PI/2);
        }
        else if (Math.abs(degreeCameras[id]) === 180)
        {
            cameras[id].position.set(0, gridSizeY / 2, gridSizeZ);
            cameras[id].rotation.set(-0.5, 0, Math.PI);
        }
        else if (degreeCameras[id] === -90 || degreeCameras[id] === 270)
        {
            cameras[id].position.set(gridSizeX / 2, 0, gridSizeZ);
            cameras[id].rotation.set(0, 0.5, Math.PI/2);
        }

        cameras[id].updateMatrixWorld();
    }

    // Определяем какая сцена выбрана
    function getIdScene(event)
    {
        var elem = event.target.parentNode.id.split('-');
        id = elem[elem.length - 1] - 1;
    }

    function onMouseDown(event) {
        getIdScene(event);
        isRotateCameras[id] = true;
        previousMouseX[id] = event.clientX;
    }

    function onMouseUp(event) {
        if (isRotateCameras[id]) {
            isRotateCameras[id] = false;
            whereGoCamera(event);
            updateCamera();
        }
    }

    function zoom(event) {
        const delta = event.deltaY > 0 ? 1 : -1;
        cameras[id].position.z += delta;
        event.preventDefault();
    }

    function animate()
    {
        requestAnimationFrame( animate );
        for (let i = 0; i < 3; i++) {
            renderers[i].render(scenes[i], cameras[i]);
        }
    }
    animate();
</script>
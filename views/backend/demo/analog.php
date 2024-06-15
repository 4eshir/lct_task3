<?php

use app\components\arrangement\TerritoryConcept;
use app\models\forms\demo\GenerateAnalogForm;
use app\models\work\TerritoryWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var GenerateAnalogForm $model */
/** @var string $data */
?>

<style>
    .scene-container {
        height: 600px;
        margin-bottom: 1rem;
    }
    .scene-container canvas {
        border-radius: 15px;
    }
</style>

<div class="object-work-form">

    <?php $form = ActiveForm::begin(['id' => 'generate-form']); ?>

    <?= $form->field($model, 'analogTerritoryId')->dropDownList(TerritoryWork::getFixedTerritories(), ['prompt' => '--']) ?>

    <?= $form->field($model, 'fullness')->dropDownList([
        TerritoryConcept::TYPE_FULLNESS_ORIGINAL => 'Оригинальная',
        TerritoryConcept::TYPE_FULLNESS_MAX => 'Максимум',
        TerritoryConcept::TYPE_FULLNESS_MID => 'Средняя',
        TerritoryConcept::TYPE_FULLNESS_MIN => 'Низкая',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сгенерировать', ['class' => 'btn btn-success', 'style' => 'width: 100%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="pre-data">

    </div>

    <div class="result" style="display: none">
        <?= $data ?>
    </div>

    <h3>Оригинальное размещение объектов на территории</h3>
    <div id="scene-container-1" class="scene-container"></div>
    <div id="anal-block-1"></div>

    <h3>Сгенерированное размещение объектов на территории</h3>
    <div id="scene-container-2" class="scene-container"></div>
    <div id="anal-block-2"></div>

</div>

<?php
$script = <<< JS
    $(document).ready(function(){
        var territoryId = $('#generateanalogform-analogterritoryid').val();
        $.ajax({
            url: '/index.php?r=backend/demo/render-arrangement-ajax',
            type: 'GET',
            data: {territoryId: territoryId},
            success: function(response){
                //$('.pre-data').html(response);
                if (!response.includes("error"))
                    init(response, 0);
            },
            error: function(xhr){
                console.log('Ошибка ' + xhr.status);
            }
        });
    });

    $('#generateanalogform-analogterritoryid').change(function(){
        var territoryId = $(this).val();
        $.ajax({
            url: '/index.php?r=backend/demo/render-arrangement-ajax',
            type: 'GET',
            data: {territoryId: territoryId},
            success: function(response){
                //$('.pre-data').html(response);
                if (!response.includes("error"))
                    init(response, 0);
            },
            error: function(xhr){
                console.log('Ошибка ' + xhr.status);
            }
        });
    });
JS;

// Регистрируем скрипт
$this->registerJs($script);
?>

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
    var degreeCameras = [0, 0];
    var previousMouseX = [0, 0];
    var id;
    var gridSizeX = 10, gridSizeY = 10, gridSizeZ = 10;
    var objectsToRemove = [];
    for (let i = 0; i < 2; i++)
    {
        objectsToRemove[i] = [];
    }

    // Инициализировали создание сцен и добавление триггеров
    for (let i = 0; i < 2; i++) {
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

        for (let j = 0; j < gridSizeX * gridSizeY; j++) {
            var cellGeometry = new THREE.BoxBufferGeometry(1, 1, 0.01);
            var cellMaterial = new THREE.MeshBasicMaterial({ color: '#000000', transparent: true, opacity: 0.5, side: THREE.DoubleSide });
            var cell = new THREE.Mesh(cellGeometry, cellMaterial);
            cell.position.set(j % gridSizeX - gridSizeX / 2, Math.floor(j / gridSizeX) - gridSizeY / 2, 0);
            objectsToRemove[i].push(cell);
            scene.add(cell);
        }
    }

    // Очистка сцены
    function removeFromScene() {
        for (let object of objectsToRemove[id]) {
            scenes[id].remove(object);
        }
        objectsToRemove[id] = [];
    }

    // Отрисовываем сетку и объекты на ней
    function init(date, type) {
        id = type;

        var dateObj = JSON.parse(date.substring(date.indexOf('{'), date.lastIndexOf('}}}') + 3));
        var gridMesh = new THREE.Group();

        removeFromScene();

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

        scenes[id].add(gridMesh);
        objectsToRemove[type].push(gridMesh);
        cameras[id].position.set(0, -(gridSizeY / 2), gridSizeZ);
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
                        model.position.set(dateObj.result.objects[index].dotCenter.x + rotateX, dateObj.result.objects[index].dotCenter.y + rotateY, 0);

                        // Добавляем модель в сцену
                        scenes[id].add(model);
                        objectsToRemove[id].push(model);
                    },
                    undefined,
                    function (error) {
                        // Если модель отсутствует, то заменяем её на примитивный полигон (параллелепипед)
                        const geometry = new THREE.BoxGeometry(dateObj.result.objects[index].length, dateObj.result.objects[index].width, dateObj.result.objects[index].height);
                        const oneObject = new THREE.Mesh(geometry, material);

                        oneObject.position.set(dateObj.result.objects[index].dotCenter.x + rotateX, dateObj.result.objects[index].dotCenter.y + rotateY, 0.5);
                        oneObject.rotation.z = rotation;
                        scenes[id].add(oneObject);
                        objectsToRemove[id].push(oneObject);
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
        for (let i = 0; i < 2; i++) {
            renderers[i].render(scenes[i], cameras[i]);
        }
    }
    animate();
</script>

<script>
    var date = '<?php echo $data; ?>';
    console.log(date);
    init(date, 1);
</script>
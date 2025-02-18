    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\TransparenciaController;
    use App\Http\Controllers\DocenteController;
    use App\Http\Controllers\SliderController;
    use App\Http\Controllers\CarreraController;
    use App\Http\Controllers\EmpresaController; // Agrega la importación del controlador de Empresas
    use App\Http\Controllers\EstudiantesController;
    use App\Http\Controllers\PublicacionController;
    use App\Http\Controllers\PostulacionController;
    use App\Http\Controllers\CursoTecnicoController; // Versión corregida

    Route::middleware('api')->group(function () {
        // Rutas para Transparencia
        Route::get('/transparencia', [TransparenciaController::class, 'index']);
        Route::get('/transparencia/{id}', [TransparenciaController::class, 'show']);
        Route::post('/transparencia', [TransparenciaController::class, 'store']);
        Route::put('/transparencia/{id}', [TransparenciaController::class, 'update']);
        Route::delete('/transparencia/{id}', [TransparenciaController::class, 'destroy']);
        Route::get('/docentes', [DocenteController::class, 'index']);
        Route::get('/docentes/{id}', [DocenteController::class, 'show']);
        Route::post('/docentes', [DocenteController::class, 'store']);
        Route::put('/docentes/{id}', [DocenteController::class, 'update']);
        Route::delete('/docentes/{id}', [DocenteController::class, 'destroy']);
        Route::get('/slider', [SliderController::class, 'index']);
        Route::get('/slider/{id}', [SliderController::class, 'show']);
        Route::post('/slider', [SliderController::class, 'store']);
        Route::put('/slider/{id}', [SliderController::class, 'update']);
        Route::delete('/slider/{id}', [SliderController::class, 'destroy']);
        Route::get('/carreras', [CarreraController::class, 'index']);
        Route::get('/carreras/{id}', [CarreraController::class, 'show']);
        Route::post('/carreras', [CarreraController::class, 'store']);
        Route::put('/carreras/{id}', [CarreraController::class, 'update']);
        Route::delete('/carreras/{id}', [CarreraController::class, 'destroy']);

        Route::get('/empresas', [EmpresaController::class, 'index']); // Ruta para obtener todas las empresas
        Route::get('/empresas/{id}', [EmpresaController::class, 'show']); // Ruta para obtener una empresa por ID
        Route::post('/empresas', [EmpresaController::class, 'store']); // Ruta para crear una nueva empresa
        Route::put('/empresas/{id}', [EmpresaController::class, 'update']); // Ruta para actualizar una empresa
        Route::delete('/empresas/{id}', [EmpresaController::class, 'destroy']);

        Route::get('/estudiantes', [EstudiantesController::class, 'index']);
        Route::get('/estudiantes/{dni}', [EstudiantesController::class, 'show']);
        Route::post('/estudiantes', [EstudiantesController::class, 'store']);
        Route::put('/estudiantes/{dni}', [EstudiantesController::class, 'update']);
        Route::delete('/estudiantes/{dni}', [EstudiantesController::class, 'destroy']);

        Route::get('/publicaciones', [PublicacionController::class, 'index']);
        Route::get('/publicaciones/{id}', [PublicacionController::class, 'show']);
        Route::post('/publicaciones', [PublicacionController::class, 'store']);
        Route::put('/publicaciones/{id}', [PublicacionController::class, 'update']);
        Route::delete('/publicaciones/{id}', [PublicacionController::class, 'destroy']);

        Route::get('/postulaciones', [PostulacionController::class, 'index']);
        Route::get('/postulaciones/{id}', [PostulacionController::class, 'show']);
        Route::post('/postulaciones', [PostulacionController::class, 'store']);
        Route::put('/postulaciones/{id}', [PostulacionController::class, 'update']);
        Route::delete('/postulaciones/{id}', [PostulacionController::class, 'destroy']);

        Route::get('/cursos-tecnicos', [CursoTecnicoController::class, 'index']);
        Route::get('/cursos-tecnicos/{id}', [CursoTecnicoController::class, 'show']);
        Route::post('/cursos-tecnicos', [CursoTecnicoController::class, 'store']);
        Route::put('/cursos-tecnicos/{id}', [CursoTecnicoController::class, 'update']);
        Route::delete('/cursos-tecnicos/{id}', [CursoTecnicoController::class, 'destroy']);

    });

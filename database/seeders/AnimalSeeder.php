<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\FotoAnimal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnimalSeeder extends Seeder
{
    public function run(): void
    {
        $animales = [
            ['nombre' => 'Luna',    'especie' => 'Perro', 'raza' => 'Labrador',       'edad_meses' => 18,  'sexo' => 'hembra', 'descripcion' => 'Luna es cariñosa y juguetona. Le encanta correr por el parque y hace las delicias de todos.', 'estado_salud' => 'Vacunada y esterilizada.', 'fecha_ingreso' => '2026-01-10'],
            ['nombre' => 'Rocky',   'especie' => 'Perro', 'raza' => 'Pastor Alemán',  'edad_meses' => 36,  'sexo' => 'macho',  'descripcion' => 'Rocky es leal y protector. Ideal para familias con experiencia en perros grandes.', 'estado_salud' => 'Vacunado y desparasitado.', 'fecha_ingreso' => '2026-02-03'],
            ['nombre' => 'Mochi',   'especie' => 'Gato',  'raza' => 'Siamés',         'edad_meses' => 12,  'sexo' => 'macho',  'descripcion' => 'Mochi es muy curioso y sociable. Se lleva bien con otros gatos.', 'estado_salud' => 'Vacunado y castrado.', 'fecha_ingreso' => '2026-01-22'],
            ['nombre' => 'Nala',    'especie' => 'Gato',  'raza' => 'Europeo común',  'edad_meses' => 8,   'sexo' => 'hembra', 'descripcion' => 'Nala llegó siendo muy pequeña. Es tranquila y le encanta el sol y los mimos.', 'estado_salud' => 'Vacunada y esterilizada.', 'fecha_ingreso' => '2026-03-01'],
            ['nombre' => 'Max',     'especie' => 'Perro', 'raza' => 'Beagle',         'edad_meses' => 24,  'sexo' => 'macho',  'descripcion' => 'Max es energético y alegre. Necesita paseos diarios y mucho cariño.', 'estado_salud' => 'Vacunado.', 'fecha_ingreso' => '2026-02-18'],
            ['nombre' => 'Cleo',    'especie' => 'Gato',  'raza' => 'Maine Coon',     'edad_meses' => 30,  'sexo' => 'hembra', 'descripcion' => 'Cleo es majestuosa y tranquila. Le gusta observar el exterior desde la ventana.', 'estado_salud' => 'Vacunada y esterilizada.', 'fecha_ingreso' => '2025-12-15'],
            ['nombre' => 'Toby',    'especie' => 'Perro', 'raza' => 'Mestizo',        'edad_meses' => 48,  'sexo' => 'macho',  'descripcion' => 'Toby llegó de la calle pero confía en las personas. Buen perro para casa tranquila.', 'estado_salud' => 'Vacunado y desparasitado.', 'fecha_ingreso' => '2025-11-30'],
            ['nombre' => 'Kira',    'especie' => 'Perro', 'raza' => 'Husky Siberiano','edad_meses' => 20,  'sexo' => 'hembra', 'descripcion' => 'Kira tiene una mirada preciosa y le encanta la nieve y el ejercicio.', 'estado_salud' => 'Vacunada.', 'fecha_ingreso' => '2026-03-10'],
            ['nombre' => 'Oliver',  'especie' => 'Gato',  'raza' => 'Persa',          'edad_meses' => 15,  'sexo' => 'macho',  'descripcion' => 'Oliver es elegante y tranquilo. Perfecto para un piso sin mucho ruido.', 'estado_salud' => 'Vacunado y castrado.', 'fecha_ingreso' => '2026-04-05'],
            ['nombre' => 'Simba',   'especie' => 'Perro', 'raza' => 'Golden Retriever','edad_meses' => 10, 'sexo' => 'macho',  'descripcion' => 'Simba es un cachorro lleno de energía. Aprende rápido y adora a los niños.', 'estado_salud' => 'Primera vacuna puesta.', 'fecha_ingreso' => '2026-04-20'],
            ['nombre' => 'Lola',    'especie' => 'Perro', 'raza' => 'Caniche',        'edad_meses' => 60,  'sexo' => 'hembra', 'descripcion' => 'Lola es mayor y serena. Busca un hogar tranquilo donde pasar sus últimos años feliz.', 'estado_salud' => 'Vacunada y esterilizada.', 'fecha_ingreso' => '2025-10-01'],
            ['nombre' => 'Zara',    'especie' => 'Gato',  'raza' => 'Bengalí',        'edad_meses' => 22,  'sexo' => 'hembra', 'descripcion' => 'Zara tiene un pelaje espectacular. Es activa y le encantan los juguetes con plumas.', 'estado_salud' => 'Vacunada y esterilizada.', 'fecha_ingreso' => '2026-02-28'],
        ];

        // URLs de fotos de animales de dominio público (Unsplash source / place.dog / cataas)
        $fotos_urls = [
            'Luna'   => 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=600&q=80',
            'Rocky'  => 'https://images.unsplash.com/photo-1589941013453-ec89f33b5e95?w=600&q=80',
            'Mochi'  => 'https://images.unsplash.com/photo-1518791841217-8f162f1912da?w=600&q=80',
            'Nala'   => 'https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=600&q=80',
            'Max'    => 'https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=600&q=80',
            'Cleo'   => 'https://images.unsplash.com/photo-1529778873920-4da4926a72c2?w=600&q=80',
            'Toby'   => 'https://images.unsplash.com/photo-1477884213360-7e9d7dcc1e48?w=600&q=80',
            'Kira'   => 'https://images.unsplash.com/photo-1605568427561-40dd23c2acea?w=600&q=80',
            'Oliver' => 'https://images.unsplash.com/photo-1574158622682-e40e69881006?w=600&q=80',
            'Simba'  => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=600&q=80',
            'Lola'   => 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=600&q=80',
            'Zara'   => 'https://images.unsplash.com/photo-1592194996308-7b43878e84a6?w=600&q=80',
        ];

        $dir = storage_path('app/public/animales');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        foreach ($animales as $datos) {
            $animal = Animal::create([
                'nombre'        => $datos['nombre'],
                'especie'       => $datos['especie'],
                'raza'          => $datos['raza'],
                'edad_meses'    => $datos['edad_meses'],
                'sexo'          => $datos['sexo'],
                'descripcion'   => $datos['descripcion'],
                'estado_salud'  => $datos['estado_salud'],
                'estado'        => 'disponible',
                'fecha_ingreso' => $datos['fecha_ingreso'],
            ]);

            $url = $fotos_urls[$datos['nombre']] ?? null;
            if ($url) {
                $this->command->info("Descargando foto de {$datos['nombre']}...");
                $contenido = @file_get_contents($url);
                if ($contenido) {
                    $nombre_archivo = Str::random(40) . '.jpg';
                    file_put_contents($dir . '/' . $nombre_archivo, $contenido);
                    FotoAnimal::create([
                        'id_animal'      => $animal->id,
                        'nombre_archivo' => $nombre_archivo,
                    ]);
                    $this->command->info("  ✓ Foto guardada: {$nombre_archivo}");
                } else {
                    $this->command->warn("  ✗ No se pudo descargar la foto de {$datos['nombre']}");
                }
            }
        }

        $this->command->info('Seeder completado: ' . count($animales) . ' animales añadidos.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            //-----Teclado-----
            [
                'category_ID' => '1',
                'name' => 'Teclado óptico-mecánico K100 RGB, dorado medianoche',
                'description' => 'El incomparable teclado óptico-mecánico para juegos CORSAIR K100 RGB combina un impresionante diseño de aluminio anodizado de dos tonos en dorado, iluminación RGB CORSAIR AXON y los interruptores CORSAIR OPX RGB.',
                'brand' => 'Corsair',
                'price' => '19999.99',
                'product_official_site' => 'https://www.corsair.com/lm/es/Categor%C3%ADas/Productos/Teclados-para-juegos/Teclados-RGB-mec%C3%A1nicos-para-juegos/K100/p/CH-912A21A-NA',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/1.png'
            ],
            [
                'category_ID' => '1',
                'name' => 'MX MECHANICAL',
                'description' => 'Teclado inalámbrico iluminado de alto desempeño.',
                'brand' => 'Logitech',
                'price' => '14999.99',
                'product_official_site' => 'https://www.logitech.com/es-ar/products/keyboards/mx-mechanical.html',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/2.png'
            ],
            [
                'category_ID' => '1',
                'name' => 'G915 TKL',
                'description' => 'Un gran avance en diseño e ingeniería. Tecnología inalámbrica LIGHTSPEED de calidad profesional, RGB LIGHTSYNC avanzada e interruptores mecánicos de perfil bajo y nivel profesional.',
                'brand' => 'Logitech',
                'price' => '16999.99',
                'product_official_site' => 'https://www.logitechg.com/es-ar/products/gaming-keyboards/g915-tkl-wireless.920-009660.html',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/3.png'
            ],
            //-----Mouse-----
            [
                'category_ID' => '2',
                'name' => 'IRONCLAW RGB FPS/MOBA',
                'description' => 'El ratón para juegos CORSAIR IRONCLAW RGB combina un sensor óptico de precisión de 18.000 ppp con un cuerpo ligero de 105 g y una forma esculpida específicamente para sujeción con la palma y manos grandes.',
                'brand' => 'Corsair',
                'price' => '7999.99',
                'product_official_site' => 'https://www.corsair.com/lm/es/Categor%C3%ADas/Productos/Ratones-para-juegos/Ratones-para-juegos-de-acci%C3%B3n-r%C3%A1pida-FPS/Rat%C3%B3n-para-juegos-IRONCLAW-RGB-FPS-MOBA/p/CH-9307011-NA',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/4.png'
            ],
            [
                'category_ID' => '2',
                'name' => 'G502 X PLUS',
                'description' => 'G502 X PLUS es la última adición a la legendaria gama G502. Reinventado con nuestros primerísimos interruptores híbridos LIGHTFORCE, tecnología inalámbrica LIGHTSPEED, RGB LIGHTSYNC, sensor HERO 25K, etc.',
                'brand' => 'Logitech',
                'price' => '10999.99',
                'product_official_site' => 'https://www.logitechg.com/es-ar/products/gaming-mice/g502-x-plus-wireless-lightforce.910-006170.html',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/5.png'
            ],
            [
                'category_ID' => '2',
                'name' => 'RAZER VIPER MINI SIGNATURE EDITION',
                'description' => 'Ahora existe algo aún mejor que el ratón de tus sueños. Para los que se atreven a quererlo todo, hazte con una obra maestra que supera a la competencia en peso, diseño y rendimiento.',
                'brand' => 'Razer',
                'price' => '15999.99',
                'product_official_site' => 'https://www.razer.com/latam-es/gaming-mice/razer-viper-mini-signature-edition',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/6.png'
            ],
            //-----Monitor-----
            [
                'category_ID' => '3',
                'name' => 'Odyssey Ark 55" UHD 165Hz 1000R',
                'description' => 'La curva 1000R se ajusta a los contornos del ojo humano para lograr un realismo inimaginable. La tecnología Quantum Matrix con Quantum Mini LED proporciona una imagen cristalina.',
                'brand' => 'Samsung',
                'price' => '25999.99',
                'product_official_site' => 'https://www.samsung.com/ar/monitors/gaming/odyssey-ark-g97nb-55-inch-165hz-1ms-curved-uhd-4k-ls55bg970nlxzb/',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/7.png'
            ],
            [
                'category_ID' => '3',
                'name' => 'LG 27GP950-B',
                'description' => 'El LG UltraGear™ 27GP950 es un monitor gaming potente con funciones de alto rendimiento y que se adapta a las más altas exigencias de tus videojuegos.',
                'brand' => 'LG',
                'price' => '17999.99',
                'product_official_site' => 'https://www.lg.com/ar/monitores/lg-27gp950-b',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/8.png'
            ],
            [
                'category_ID' => '3',
                'name' => 'ROG Strix XG35VQ',
                'description' => 'ROG Strix XG35VQ Monitor curvo para gaming: 35 pulgadas, UWQHD (3440x1440), 100 Hz, Extreme Low Motion Blur, Adaptive-Sync (FreeSync™)',
                'brand' => 'Asus',
                'price' => '20999.99',
                'product_official_site' => 'https://rog.asus.com/latin/monitors/above-34-inches/rog-strix-xg35vq-model/',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/9.png'
            ],
            //-----Chasis/Gabinete-----
            [
                'category_ID' => '4',
                'name' => 'Gabinete MicroATX CH370 WH',
                'description' => 'La DeepCool CH370 WH es una caja Micro ATX elegante y minimalista con amplia capacidad de refrigeración que admite un radiador de 360 mm y hasta 8 ventiladores de 120 mm para una potencia compacta.',
                'brand' => 'DeepCool',
                'price' => '10999.99',
                'product_official_site' => 'https://es.deepcool.com/products/Cases/fulltowercases/CH370-Micro-ATX-Case/2022/15966.shtml',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/10.png'
            ],
            [
                'category_ID' => '4',
                'name' => 'Core P6 Tempered Glass Racing Green Mid Tower Chassis',
                'description' => 'The Core P6 TG Racing Green is a transformable CEB Mid Tower Case that can be either a closed or open styled case with Tt LCS certification.',
                'brand' => 'Thermaltake',
                'price' => '79999.99',
                'product_official_site' => 'https://es.thermaltake.com/core-p6-tempered-glass-racing-green-mid-tower-chassis.html',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/11.png'
            ],
            [
                'category_ID' => '4',
                'name' => 'Chasis ATX semitorre con cristal templado 4000D',
                'description' => 'El CORSAIR 4000D es un chasis ATX semitorre distintivo, pero minimalista, con una sencilla gestión del cableado y una refrigeración excepcional gracias a los dos ventiladores CORSAIR AirGuide incluidos.',
                'brand' => 'Corsair',
                'price' => '9999.99',
                'product_official_site' => 'https://www.corsair.com/lm/es/Categor%C3%ADas/Productos/Chasis/Chasis-de-semitorre-ATX/4000D-Tempered-Glass-Mid-Tower-ATX-Case/p/CC-9011199-WW',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/12.png'
            ],
            //-----Procesador-----
            [
                'category_ID' => '5',
                'name' => 'Intel® Core™ i7-13850HX',
                'description' => 'caché de 30 MB, hasta 5,30 GHz',
                'brand' => 'Intel',
                'price' => '20999.99',
                'product_official_site' => 'https://www.intel.la/content/www/xl/es/products/sku/232161/intel-core-i713850hx-processor-30m-cache-up-to-5-30-ghz/specifications.html',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/13.png'
            ],
            [
                'category_ID' => '5',
                'name' => 'AMD Ryzen™ 7 7700X',
                'description' => 'Lleva a tu equipo a la victoria con el mejor procesador de juegos AMD de 8 núcleos.',
                'brand' => 'AMD',
                'price' => '20999.99',
                'product_official_site' => 'https://www.amd.com/es/products/cpu/amd-ryzen-7-7700x',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/14.png'
            ],
            //-----Placa de video-----
            [
                'category_ID' => '6',
                'name' => 'AORUS GeForce RTX™ 4080 16GB XTREME WATERFORCE WB',
                'description' => 'Designed for DIY PC enthusiasts aiming to create unique custom loop builds and achieve the highest possible performance in silence.',
                'brand' => 'Gigabyte',
                'price' => '100999.99',
                'product_official_site' => 'https://www.gigabyte.com/es/Graphics-Card/GV-N4080AORUSX-WB-16GD#kf',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/15.png'
            ],
            [
                'category_ID' => '6',
                'name' => 'ROG Strix GeForce RTX™ 3090 24GB GDDR6X OC EVA Edition',
                'description' => 'Es 2022. The Republic of Gamers está lanzando nuevos equipos para el proyecto EVANGELION. La ROG Strix GeForce RTX™ 3090 EVA Edition viene equipada con una gran variedad de funciones que mejoran el rendimiento.',
                'brand' => 'Asus',
                'price' => '99999.99',
                'product_official_site' => 'https://rog.asus.com/latin/graphics-cards/graphics-cards/rog-strix/rog-strix-rtx3090-o24g-eva-model/',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/16.png'
            ],
            [
                'category_ID' => '6',
                'name' => 'ZOTAC GAMING GeForce RTX 4070 Ti AMP AIRO',
                'description' => 'Love Gaming with the all-new ZOTAC GAMING GeForce® graphics card powered by the NVIDIA Ada Lovelace architecture and DLSS 3.',
                'brand' => 'ZOTAC',
                'price' => '70999.99',
                'product_official_site' => 'https://www.zotac.com/us/product/graphics_card/zotac-gaming-geforce-rtx-4070-ti-amp-airo',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/17.png'
            ],
            //-----Memoria RAM-----
            [
                'category_ID' => '7',
                'name' => 'Kingston FURY Beast DDR5 RGB',
                'description' => 'Kingston FURY™ Beast DDR5 RGB1 te permite hacer overclocking con estilo en plataformas para videojuegos de última generación mediante tecnología punta.',
                'brand' => 'Kingston',
                'price' => '5999.99',
                'product_official_site' => 'https://www.kingston.com/es/memory/gaming/kingston-fury-beast-ddr5-rgb-memory',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/18.png'
            ],
            [
                'category_ID' => '7',
                'name' => 'AORUS RGB Memory DDR5 6000MT/s 32GB Memory Kit',
                'description' => 'AORUS DDR5 RGB memory adopts a new copper-aluminum composite material heat spreader. Combine the advantages of copper\’s heat conduction and aluminum\'s heat dissipation, make sure no compromise when overclocking.',
                'brand' => 'Gigabyte',
                'price' => '11999.99',
                'product_official_site' => 'https://www.gigabyte.com/es/Memory/AORUS-RGB-Memory-DDR5-32GB--2x16GB-6000MT-s#kf',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/19.png'
            ],
            [
                'category_ID' => '7',
                'name' => 'Kit de memoria DRAM DDR4 a 3600 MHz VENGEANCE® RGB RT de 32 GB (2 x 16 GB) C16, negro',
                'description' => 'La memoria DDR4 CORSAIR VENGEANCE RGB RT realza la estética de su PC a la vez que ofrece un rendimiento excepcional optimizado para sistemas AMD.',
                'brand' => 'Corsair',
                'price' => '9999.99',
                'product_official_site' => 'https://www.corsair.com/es/es/Categor%C3%ADas/Productos/Memoria/VENGEANCE-RGB-RT-Black/p/CMN32GX4M2Z3600C16',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/20.png'
            ],
            //-----Memoria ROM-----
            [
                'category_ID' => '8',
                'name' => 'WD_BLACK SN850X NVMe™ SSD',
                'description' => 'Abróchese el cinturón para conseguir velocidades de juego extremadamente altas con la unidad SSD WD_BLACK SN850X™ NVMe. Disminuya los tiempos de carga y reduzca la ralentización, el retraso y los poppings.',
                'brand' => 'Western Digital',
                'price' => '15999.99',
                'product_official_site' => 'https://www.westerndigital.com/es-la/products/internal-drives/wd-black-sn850x-nvme-ssd#WDS100T2X0E',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/21.png'
            ],
            [
                'category_ID' => '8',
                'name' => 'WD Blue SA510 SATA SSD con carcasa de 2,5”/7 mm',
                'description' => 'Mejore el rendimiento de su PC para que pueda impulsar su trabajo y aumentar su potencial creativo. Diseñada específicamente para profesionales, creadores de contenido y editores.',
                'brand' => 'Western Digital',
                'price' => '10999.99',
                'product_official_site' => 'https://www.westerndigital.com/es-la/products/internal-drives/wd-blue-sa510-sata-2-5-ssd#WDS250G3B0A',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/22.png'
            ],
            [
                'category_ID' => '8',
                'name' => 'SSD SATA A400',
                'description' => 'La unidad A400 de estado sólido de Kingston ofrece enormes mejoras en la velocidad de respuesta, sin actualizaciones adicionales del hardware.',
                'brand' => 'Kingston',
                'price' => '8999.99',
                'product_official_site' => 'https://www.kingston.com/es/ssd/a400-solid-state-drive',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/23.png'
            ],
            //-----Motherboard-----
            [
                'category_ID' => '9',
                'name' => 'ROG STRIX Z790-H GAMING WIFI',
                'description' => 'Motherboard Intel® Z790 LGA 1700 ATX con 16 + 1 fases de poder, DDR5 hasta 7800 MT/s, PCIe 5.0 x16 SafeSlot con Q-Release, WiFi 6E, AI Overclocking, AI Cooling II e iluminación Aura Sync RGB',
                'brand' => 'Asus',
                'price' => '20999.99',
                'product_official_site' => 'https://rog.asus.com/latin/motherboards/rog-strix/rog-strix-z790-h-gaming-wifi-model/',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/24.png'
            ],
            [
                'category_ID' => '9',
                'name' => 'X670E AORUS XTREME',
                'description' => 'With the fast-moving technology changes, GIGABYTE always follows the latest trends and provides customers with advanced features and latest technologies.',
                'brand' => 'Gigabyte',
                'price' => '20999.99',
                'product_official_site' => 'https://www.gigabyte.com/ar/Motherboard/X670E-AORUS-XTREME-rev-10#kf',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/25.png'
            ],
            [
                'category_ID' => '9',
                'name' => 'TUF GAMING B650-PLUS WIFI',
                'description' => 'La ASUS TUF GAMING B650-PLUS WIFI toma todos los elementos esenciales de los últimos procesadores AMD Ryzen de la serie 7000 y los combina con características listas para jugar y una durabilidad probada.',
                'brand' => 'Asus',
                'price' => '15999.99',
                'product_official_site' => 'https://www.asus.com/latin/motherboards-components/motherboards/tuf-gaming/tuf-gaming-b650-plus-wifi/',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/26.png'
            ],
            //-----Fuente-----
            [
                'category_ID' => '10',
                'name' => 'PRIME GX',
                'description' => 'The PRIME Series has always demonstrated outstanding performance and have become the epitome of technological excellence and quality through the years.',
                'brand' => 'Seasonic',
                'price' => '10999.99',
                'product_official_site' => 'https://seasonic.com/prime-gx',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/27.png'
            ],
            [
                'category_ID' => '10',
                'name' => 'Fuente de alimentación ATX totalmente modular y silenciosa RMe Series RM750e',
                'description' => 'CORSAIR RMe Series Fully Modular Low-Noise Power Supplies with ATX 3.0 and PCIe 5.0 compliance provide quiet, reliable power with 80 PLUS Gold efficiency to a wide variety of PC builds.',
                'brand' => 'Corsair',
                'price' => '9999.99',
                'product_official_site' => 'https://www.corsair.com/lm/es/Categor%C3%ADas/Productos/Unidades-de-fuente-de-alimentaci%C3%B3n/Fuente-de-alimentaci%C3%B3n-ATX-totalmente-modular-y-silenciosa-RMe-Series/p/CP-9020262-AR',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/28.png'
            ],
            [
                'category_ID' => '10',
                'name' => 'AORUS P1200W 80+ PLATINUM MODULAR',
                'description' => 'producto5descripcion',
                'brand' => 'Gigabyte',
                'price' => '15999.99',
                'product_official_site' => 'https://www.gigabyte.com/es/Power-Supply/GP-AP1200PM#kf',
                'product_image' => 'https://raw.githubusercontent.com/mjuan99/public_images/main/images/29.png'
            ]
        ]);
    }
}

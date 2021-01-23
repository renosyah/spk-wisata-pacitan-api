# SPK wisata pacitan api (CORE API)

## Kebutuhan

- PHP 7
- MysqlDB or MariaDB


<br>
<br>


## Konfigurasi Database

- buka cmd lalu buka mysql console

```

c:\xampp\mysql\bin\mysql -u root -p

```

- buat database spk_wisata_pacitan_api_db;

```

create database spk_wisata_pacitan_api_db;
use spk_wisata_pacitan_api_db;

```

- copy dan paste isi file di \sql\schema.sql ke console

<br>
<br>

## Konfiguras PHP

- buka file api/config.php dan sesuaikan isinya dengan konfigurasi anda sendiri

```

<?php

return array(
    'host' => 'localhost',
    'port' => '3306',
    'name' => 'ecommerce_db',
    'username' => 'root',
    'password' => '',
);

?>

```

<br>
<br>

## Cara Menjalankan

- buka cmd di direktori ini lalu ketik

```

    php -S {YOUR_IP}:80

```

atau

```

    php -S localhost:80

```
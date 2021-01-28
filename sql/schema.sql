CREATE TABLE admin(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama TEXT,
    username TEXT,
    password TEXT
);

CREATE TABLE kategori(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama TEXT,
    deskripsi TEXT,
    url_gambar TEXT   
);

CREATE TABLE kriteria(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama TEXT,
    deskripsi TEXT,
    nilai FLOAT,
    attribut TEXT
);

CREATE TABLE kriteria_range(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    kriteria_id INT(11) NOT NULL,
    nama TEXT,
    deskripsi TEXT,
    nilai FLOAT,
    status INT
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id)
);

CREATE TABLE data_pariwisata(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    kategori_id INT(11) NOT NULL,
    nama TEXT,
    lokasi TEXT,
    deskripsi TEXT,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

CREATE TABLE data_pariwisata_attribut(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    data_pariwisata_id INT(11) NOT NULL,
    kriteria_range_id INT(11) NOT NULL,
    FOREIGN KEY (data_pariwisata_id) REFERENCES data_pariwisata(id),
    FOREIGN KEY (kriteria_range_id) REFERENCES kriteria_range(id)
);
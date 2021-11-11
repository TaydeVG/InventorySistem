ALTER TABLE laboratorio ADD FOREIGN KEY(admin) 
REFERENCES administrador(id);

ALTER TABLE equipo ADD FOREIGN KEY(id_laboratorio) 
REFERENCES laboratorio(id);

ALTER TABLE reactivo ADD FOREIGN KEY(id_laboratorio) 
REFERENCES laboratorio(id);

ALTER TABLE recipiente ADD FOREIGN KEY(id_laboratorio) 
REFERENCES laboratorio(id);

ALTER TABLE mantenimiento ADD FOREIGN KEY(id_equipo) 
REFERENCES equipo(id);

ALTER TABLE recipiente ADD FOREIGN KEY(id_tipo_material) 
REFERENCES tipo_material(id);
-- chyby:
INSERT INTO city (id) VALUES ('ul');
INSERT INTO city (name) VALUES ('Ústí nad Labem');
INSERT INTO city (id, name) VALUES ('ull', 'Ústí nad Labem');

-- ok:
INSERT INTO city (id, name) VALUES ('sf', 'San Francisco');
INSERT INTO city (id, name) VALUES ('ul', 'Ústí nad Labem');
INSERT INTO city (id, name) VALUES ('lo', 'Louny');
INSERT INTO city (id, name) VALUES ('bn', 'Bílina');

-- chyba:
INSERT INTO city (id, name) VALUES ('bi', 'Bílina');

-- chyby:
INSERT INTO weather VALUES ('sf', 26, 17, '2014-10-03');
INSERT INTO weather VALUES ('dr',  8, 12, '2014-10-02');

INSERT INTO weather
  VALUES ('sf', 19, 29, '2014-10-02'),
         ('ul',  7, 16, '2014-10-02'),
         ('lo', 12, 18, '2014-10-02');

INSERT INTO weather
  VALUES ('ul', 14, 21);

-- chyba:
INSERT INTO weather VALUES ('ul', 14, 21);

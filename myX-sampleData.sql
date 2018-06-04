/* myXData.sql
 * myX sample data
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-04
 */

INSERT INTO `myX`.`users` VALUES (
    2,                  /* userID */
    "Fulano",           /* username */
    "8fa14cdd754f91cc6554c9e71929cce7", /* password (encrypted) */
    "fulano@gmail.com", /* email */
    "2000-01-01",       /* birthdate */
    2,                  /* defaultGenre */
    "Descripción general: nacionalidad, edad, apariencia...",
    "Descripción física: estatura, complexión, color de la piel...",
    "Descripción genital: Pecho, vagina, culete...",
    "Descripción de carácter: Rasgos de personalidad, manías...",
    2,                  /* GUILang */
    10,                 /* resultsPerPage */
    1,                  /* listsOrder */
    2                   /* userKind */
);

/*
INSERT INTO `myX`.`users` VALUES (
    3,
    "Pepita",
    "8fa14cdd754f91cc6554c9e71929cce7",
    "pepita@gmail.com",
    "2000-01-01",
    1,
    "General description: Nationality, age, general appearance…",
    "Body description: Height, appearance, body complexity, body hair…",
    "Genital description: Penis size and shape, testicles…",
    "Bottom description: Size and shape, hair...",
    1,
    25,
    1,
    2
);
*/


INSERT INTO `myX`.`countries` VALUES (18, "España", 2);
INSERT INTO `myX`.`countries` VALUES (19, "Francia", 2);
INSERT INTO `myX`.`countries` VALUES (20, "UK", 2);
INSERT INTO `myX`.`countries` VALUES (21, "Israel", 2);
INSERT INTO `myX`.`countries` VALUES (22, "Jordania", 2);
/* values 1..17 reserved by Sarkodeiktes */

/*
 * sample data for tabla 'kinds'
 * (values 1..10 reserved by Sarkodeiktes).
 */
INSERT INTO `myX`.`kinds` VALUES (
    11,
    "(genérico)",
    2
);

INSERT INTO `myX`.`kinds` VALUES (
    12,
    "casa particular",
    2
);

INSERT INTO `myX`.`kinds` VALUES (
    13,
    "hotel",
    2
);

INSERT INTO `myX`.`kinds` VALUES (
    14,
    "naturaleza",
    2
);

/*
 * sample data for tabla 'loca'
 * (values 1..733 reserved by Sarkodeiktes).
 */

INSERT INTO `myX`.`loca` VALUES (
    734,
    "",
    "Cartagena: hotel NH Campo de Cartagena",
    3,
    "Calle Ciudadela, 24, 30203 Cartagena, Murcia",
    18,
    13,
    "hotel de precio asequible situado en un lugar tranquilo si bien no muy céntrico",
    "37.612314, -0.976620",
    "",
    "www.nh-hotels.com/Cartagena/Campo-Cartagena",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    735,
    "",
    "Cartagena: Apartamento de Calíope",
    3,
    "Calle Carlos III, 33, 30201 Cartagena, Murcia",
    18,
    12,
    "",
    "37.605995, -0.983976",
    "37.599019, -0.985648",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    736,
    "",
    "Sevilla: hostal Atenas",
    3,
    "Calle Caballerizas 1, 41003 Sevilla",
    18,
    13,
    "hostal en el centro de la ciudad, cerca de la Casa de Pilatos, a precios asequibles",
    "37.390535, -5.987844",
    "",
    "www.hostal-atenas.com",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    737,
    "",
    "Granada: hotel Granada Center",
    3,
    "Avenida Fuente Nueva s/n, 18002 Granada",
    18,
    13,
    "hotel muy convenientemente situado, que dispone de unas habitaciones muy confortables y multitud de servicios",
    "37.179142, -3.607931",
    "",
    "www.hotelescenter.es/hotel-granada-center/",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    738,
    "",
    "Montpelier: apartamento de Melpómene",
    3,
    "12 Bvd Victor Hugo, 34000 Montpellier",
    19,
    12,
    "apartamento situado en el centro de la ciudad, muy cercano a la plaza Comédie",
    "43.606759, 3.878278",
    "43.608464, 3.879502",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    739,
    "",
    "Montpelier: hotel St-Roch Centre",
    3,
    "14 rue Jules Ferry	Montpellier	34000",
    19,
    13,
    "hotel muy convenientemente situado frente a la estación Montpellier Saint-Roch",
    "43.604597, 3.879670",
    "",
    "hotel-montpellier-gare.fr",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    740,
    "",
    "Edimburgo: hostal Princes Street East Backpackers",
    3,
    "",
    20,
    13,
    "hostal low cost pero muy bien situado en el centro de Edinburgo, cerca de la estación Edinburgh Waverley",
    "55.953651, -3.190262",
    "",
    "edinburghbackpackers.com",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    741,
    "",
    "Jerusalén: apartamento de Terpsícore",
    3,
    "Meir Shaham 37, Jerusalem",
    21,
    12,
    "la casa de Terpsícore está situada junto al pintoresco barrio de Nachalat Shiv'a, en el centro de Jerusalén",
    "31.779427, 35.216079",
    "31.777645, 35.234488",
    "" ,
    2
);

INSERT INTO `myX`.`loca` VALUES (
    742,
    "",
    "Ammán: hotel Zamzam Towers",
    3,
    "Wasfi Altal St., Amman (Khalda-Wasfi Al-Tal), Jordan",
    22,
    13,
    "el hotel se halla al norte de la ciudad, a unos 45 minutos del aeropuerto",
    "31.997080, 35.853016",
    "",
    "www.zamzamtowershotel.com",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    743,
    "",
    "Cabo de Agde: playa naturista en torno al chiringuito «Paralia»",
    3,
    "playa naturista «La Baie des Cochons», al este del complejo hotelero, junto a las dunas",
    19,
    14,
    "el Cabo de Agde es un lugar recreacional en el que se juntan libertinos de toda Europa para disfrutar del sol, de la playa... y del sexo",
    "43.300325, 3.535978",
    "",
    "",
    2
);

/*
 * sample data for tabla 'practica'
 * (values 1..8278 reserved by Sarkodeiktes).
 */
INSERT INTO `myX`.`practica` VALUES (
    8279,
    "",
    "excitante coito activo con eyaculación",
    4,
    0,
    735,
    "2018-05-01",
    "",
    "primerísima experiencia, con Calíope, en su casa: después de haber pasado la tarde juntos me llevó a su apartamento. rápidamente afloró la pasión, y pasionalmente nos amamos.<br />la experiencia fue totalmente satisfactoria y muy, muy excitante. disfrutamos mucho con nuestros cuerpos. los preliminares, que duraron una eternidad, incluyeron múltiples felaciones y cunnilingus amén de largas rondas de pasionales besos y caricias. a continuación copulamos, y en sucesivas ocasiones y diferentes posturas la penetré dinámicamente durante no poco tiempo.<br />finalmente, en el cénit de la excitación, ambos llegamos al orgasmo, de forma sincronizada. fue perfecto. quedamos ambos exhaustos pero muy satisfechos.<br />siguió un largo lapsus de ternura, con múltiples besos y caricias.<br />Calíope es muy cariñosa y sensual, y desde el primer momento hubo mucho <i>feeling</i> entre nosotros. al marcharme de su casa quedé totalmente prendado. tanto, que pocos días más tarde volveríamos a quedar para un nuevo encuentro sexual.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8280,
    "",
    "coito activo con eyaculación",
    3,
    0,
    735,
    "2018-05-06",
    "a",
    "nuevamente nos encontramos y, tras tomar una cena romántica, nos amamos en su casa.<br />la experiencia no tuvo que envidiar en nada a la que habíamos mantenido tan sólo unos días antes, y con mucho placer disfrutamos de nuestros cuerpos y del sexo.<br />los preeliminares duraron no poco rato, y acto seguido pasamos a la acción copulatoria en una sucesión de penetraciones y otros juegos sexuales.<br />por descontado, la experiencia terminó en el orgasmo por ambas partes, si bien la sincronización no fue perfecta, y mi eyaculación no llegó sino hasta sólo algunos instantes después de haber acabado ella.<br />en la conversación post coito, Calíope propuso para mi sorpresa hacer un trío con una amiga suya, Clío, que estaba de visita en la ciudad. me sorprendió esta proposición libertina que no esperaba de una chica convencional como Calíope, aunque no dudé en aceptar. así, organizamos para vernos esa misma noche en el hotel donde se alojaba esta última.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8281,
    "",
    "coito activo en trío con eyaculación",
    3,
    0,
    734,
    "2018-05-06",
    "b",
    "trío con Calíope y Clío, siguiendo la propuesta de aquella durante la visita de ésta a nuestra ciudad. nos tomamos algo en la cafetería del hotel para romper el hielo, y al poco nos subimos a la habitación, donde nos amamos pasional y satisfactoriamente.<br />con mucho placer nos amamos los tres, si bien yo no podía evitar estar algo nervioso al ser éste mi primer trío. ellas, en cambio, estaban mas que curtidas en estas lides y condujeron la situación. a pesar de los nervios lo pasamos estupendamente.<br />XXX",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8282,
    "",
    "coito activo en trío con eyaculación",
    3,
    0,
    734,
    "2018-05-07",
    "",
    "segundo trío con Calíope y Clío, antes de que esta última marchase para su tierra. al despertarnos por la mañana de nuevo nos excitamos y consumamos.<br />la experiencia no fue tan satisfactoria como la de la noche anterior, lo cual era previsible porque ya no se trataba de ninguna novedad. a pesar de ello XXX",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8283,
    "",
    "coito activo con eyaculación",
    3,
    0,
    735,
    "2018-05-08",
    "",
    "con Calíope, en su piso. nos excitamos pensando en nuestras aventuras con su amiga el pasado fin de semana, y acto seguido nos amamos pasionalmente.<br />me dio la impresión de que Calíope pretendía de alguna manera demostrar que ella sola se bastaba y se sobraba para complacerme, como el día anterior(?) me habían complacido conjuntamente con su amiga. así, se entregó a fondo en cualquiera de sus acciones, y con mucha maestría XXX",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8284,
    "",
    "excitante coito activo con eyaculación",
    4,
    1,
    736,
    "2018-05-11",
    "",
    "en la capital hispalense, durante un viaje de recreo por Sevilla y Granada, coincidí con Talía en un bar de copas. ligamos, y acabamos la noche en mi hostal del centro.<br />con la exuberante cubana tuve una excitante experiencia que duró muchísimo rato y que tuvo varias réplicas a lo largo de la noche. disfruté de cada milimetro de su piel de ébano, así como ella disfrutó de cada detalle de mi anatomía, demostrando ser, entre otras cosas, una experta feladora. efectivamente, era ésta muy experimentada y muy viciosa. ¡y qué no me hizo!... ¡y cómo me lo hizo! :) igualmente supo darse plenamente por delante y por detrás.<br />como fruto de nuestra perfecta sincronización y armonía, en el cénit de la excitación alcanzamos el orgasmo simultaneamente. acabó dejandome exhausto. la experiencia fue apoteósica y de lo más gratificante, y merece, sin duda alguna, ser apuntada y recordada.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8285,
    "",
    "coito activo con eyaculación",
    3,
    0,
    737,
    "2018-05-13",
    "",
    "en Granada nuevamente ligué, esta vez con Euterpe, una chica regordita, aparentemente modosita y recatada, pero que en la cama es una auténtica bomba.<br />después de conocernos y de tomar algunas copas (alguna de más), se vino conmigo a mi habitación de hotel, donde con mucha satisfacción nos amamos largo y tendido. XXX",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8286,
    "",
    "juego carnal sin eyaculación",
    2,
    0,
    735,
    "2018-05-14",
    "",
    "último encuentro con Calíope, en su casa. la experiencia no resultó particularmente satisfactoria, como demuestra el hecho que ni copulamos, ni siquiera hubo eyaculación.<br />en efecto, había cierta tensión entre nosotros.<br />XXX<br />en cierta manera ambos supimos que este habría sido nuestro último encuentro: mi agitado modo de vida, viajando incesantemente por motivos laborales, suponía un obstáculo infranqueable para una relación estable, que es lo que ella estaba buscando. esto provocó que, inevitablemente, nuestra relación se enfriara hasta el punto de su extinción.",
    3,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8287,
    "",
    "coito activo sin eyaculación",
    3,
    0,
    738,
    "2018-05-16",
    "",
    "Melpómene y yo nos conocimos en un bar de Montpelier. era ésta muy graciosa y chistosa. cuando ya habíamos bebido bastante nos marchamos, y acabamos amándonos en su piso del centro de la ciudad.<br />Melpómene era algo recatada en asuntos sexuales, lo cual no deja de ser extraño siendo ésta francesa. por ejemplo: se negó rotundamente a practicar sexo anal, llegando incluso a contrariarse cuando de cuando en cuando pretendía jugar un poquitín con su prieto culete. aún así disfrutamos bastante de nuestros cuerpos y del sexo. XXX<br />antes de marcharme Melpómene me sugirió habernos visto unos días más tarde en Cabo de Agde para amarnos sin inhibiciones. yo en principio decliné la oferta, pero finalmente esta idea se hizo realidad.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8288,
    "",
    "coito activo con eyaculación",
    3,
    0,
    739,
    "2018-05-17",
    "",
    "con Erato en mi hotel, la última noche antes de dejar Montpelier para dirigirme al norte de Francia. ligamos por las apps, le propuse venir a mi habitación de hotel, y ésta se plantó allí al cabo de no mucho rato.<br />Erato resultó ser muy morbosa (aunque algo mandona de más) XXX<br />hubo mucho feeling con esta chica y, de hecho, le propuse volver a vernos a la semana siguiente (tenía previsto volver a la zona por motivos laborales). además, haciéndome el desinhibido le propuse vernos en Cabo de Agde, lugar conocido por los libertinos de toda Europa. cual fue mi sorpresa cuando aceptó.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8289,
    "",
    "Coito activo con eyaculación",
    3,
    0,
    740,
    "2018-05-20",
    "",
    "con Polímnia en mi hotel en Edinburgo. hallándome en la capital escocesa, en una escala-interludio entre mis viajes de negocios por Francia y Oriente Próximo, me propuse a mí mismo de conocer el producto local. Polímnia, una <i>bussineswoman</i> escocesa algo gordita y no muy agraciada de cara, se dejó conquistar con relativa facilidad en un bar de copas, y después accedió a acompañarme al hostal.<br />ésta resultó ser bastante viciosilla. XXX",
    3,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8290,
    "",
    "coito anal activo con eyaculación",
    3,
    0,
    741,
    "2018-05-26",
    "",
    "con Terpsícore en Jerusalén: después de una noche de copas en el <i>Tmol Shilshon</i>, un garito-cultureta del hierosolimitano barrio retro Nachalat Shiv'a, ésta me invito a ir a su apartamento. y yo no dudé en aceptar, a pesar de que ésta no era ninguna <i>Barbie</i>, sino más bien algo feílla y con un cuerpo algo fofo. igualmente tenía unos pechos impresionantes aunque no muy firmes.<br />en su casa nos amamos con placer, si bien ésta resultó ser algo modosita y muy púdica en el sexo, por lo que no hubo derroche de pasión. XXX",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8291,
    "",
    "coito activo sin eyaculación",
    3,
    0,
    742,
    "2018-05-27",
    "",
    "en mi último día del viaje de negocios por Oriente Próximo acaeció que conocí y copulé con Urania, una estudiante alemana, en mi hotel de Ammán. nos conocimos en el bar del hotel, y ante una evidente atracción mutua ésta me propuso subir a su habitación, lo cual indudablemente hize.<br />desde el minuto cero la pasión afloró por ambas partes, y pasionalmente disfrutamos de nuestros cuerpos con una miriada de preliminares, sucesiva cópula y orgasmo final. tenía ésta un cuerpecito delgadito y fibrado del que disfruté bastante, amén de unos pechos algo pequeños pero muy firmes, una maravilla al tacto y al gusto. Urania además resultó ser muy viciosilla, teniendo en cuenta lo joven que es.<br />por supuesto tras los preliminares de rigor consumamos la experiencia copulando con gran placer durante no poco rato. no obstante no llegamos a XXX",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8292,
    "",
    "felación pasiva en trío públicamente sin eyaculación",
    3,
    0,
    743,
    "2018-05-28",
    "a",
    "con Erato y Melpómene en la playa de Cabo de Agde, durante la mañana, estuvimos jugando carnalmente durante no poco rato, sin pasar a mayores.<br />tomábamos el sol en la playa, e inevitablemente nos calentamos, bien por la radiación del astro rey, bien por la fricción de nuestras manos al aplicarnos protector solar, bien al observar con el rabillo del ojo algunos juegos sexuales que se producían entre personas de nuestro entorno. así, comenzamos también nosotros a deleitarnos con nuestros cuerpos serranos.<br />disfruté mucho con mis dos francesasitas, así como de la situación morbosa. sin embargo, había demasiados mirones y, más allá del juego carnal, no hubiera sido prudente realizar algo más serio.<br />así, el juego duró no poco rato, y entre calentón y calentón nos dábamos un refrescante baño en el mar.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8293,
    "",
    "excitante coito activo en trío con eyaculación",
    4,
    1,
    743,
    "2018-05-28",
    "b",
    "con Erato y Melpómene en Cabo de Agde (2/2). más tarde, siendo la situación mucho más íntima, volvimos a deleitarnos de nuestros cuerpos llegando incluso a copular en plena playa, siendo observados -pero no molestados- por algunos de los allí presentes.<br />hacia el final de la tarde la situación era mucho más tranquila, aunque no por ello menos excitante. de hecho, algunas parejas estaban en plena acción algunos metros más allá. nos calentamos de nuevo y nos enrolamos en un largo juego sexual a tres bandas, juego que resultó ser completo con cópula y eyaculación incluidos.<br />XXX",
    4,
    1,
    2
);

/*
 * sample data for tabla 'amores'
 * (values 1..5868 reserved by Sarkodeiktes).
 */
INSERT INTO `myX`.`amores` VALUES (
    5869,
    "",
    "Calíope",
    3,
    2,
    "mujer española de 25 años de buena presencia, rubia de pelo largo y ojos color miel",
    "de estatura mediana, complexión delgada y cuerpo terso",
    "pechos no muy grandes, pero firmes y esbeltos",
    "muy cariñosa y sensual",
    "Skype: caliope1973; Badoo: caliope1973; Instagram: caliope1973",
    "Calíope María González Giménez",
    1,
    "(+34) 661 662 663",
    "caliope@gmail.com",
    "fecha de nacimiento: 1993-12-30. color favorito: verde. horóscopo: aries",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5870,
    "",
    "Clío",
    4,
    2,
    "mujer española de 32 años de muy buena apariencia, muy guapa y con una deliciosa <i>Kussmond</i>",
    "de estatura normal y un cuerpo algo rechoncho",
    "pechos grandes y prominentes",
    "Clío es simpática y muy fogosa",
    "Instagram: clio_asturias",
    "",
    1,
    "(+34) 661 662 663",
    "clio@yahoo.com",
    "fecha de nacimiento: 1986-10-25",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5871,
    "",
    "Erato",
    3,
    2,
    "chica francesa de 24 años, no demasiado agraciada de cara",
    "cuerpecillo esbelto, con cinturita de avispa y piernas delgadas",
    "pechos pequeños con prominentes pezones, lleva el vello púbico graciosamente recortado",
    "muy morbosa y muy mandona",
    "Skype: erato1973; Badoo: erato1973; Instagram: erato1973",
    "Érato María Pérez Giménez",
    0,
    "(+33) 661 662 663",
    "erato@me.com",
    "fecha de nacimiento: 1994-08-20. color favorito: verde turquesa",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5872,
    "",
    "Euterpe",
    3,
    2,
    "mujer española de 32 años de buena apariencia, cuatroojos",
    "cuerpo algo en carnes, piel muy pálida",
    "pechos grandes y algo caidos",
    "aparentemente modosita y recatada, en la cama es una auténtica bomba",
    "",
    "Euterpe María Gómez Fernández",
    0,
    "(+34) 661 662 663",
    "euterpe@gmail.com",
    "",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5873,
    "",
    "Melpómene",
    3,
    2,
    "mujer francesa de 25 años, de buen ver",
    "alta y delgada, de piel pálida",
    "pechos de tamaño mediano",
    "muy graciosa y chistosa, algo recatada en asuntos sexuales (extraño para ser francesa)",
    "Skype: melpomene1973; Badoo: melpomene1973; Instagram: melpomene1973",
    "Melpómene María López Sánchez",
    0,
    "(+34) 661 662 663",
    "melpomene@gmail.com",
    "fecha de nacimiento: 1993-06-15",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5874,
    "",
    "Polimnia",
    2,
    2,
    "mujer escocesa de 35 años, de apariencia normal aun no siendo muy agraciada de cara",
    "de complexión gruesa, cuerpo algo rollizo",
    "pechos de tamaño mediano-grande, quizá no tan grandes como cabría esperar",
    "bastante viciosilla",
    "",
    "Polimnia Evans",
    0,
    "(+44) 754 616 11 89",
    "",
    "",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5875,
    "",
    "Talía",
    4,
    2,
    "mujer cubana de 39 años, exótica mulata",
    "cuerpo delicioso, delgado y terso, color de ébano",
    "maravillosos pechos de tamaño mediano-grande, firmes",
    "muy experimentada y muy viciosa",
    "Skype: talia1973; Badoo: talia1973; Instagram: talia1973",
    "",
    0,
    "(+34) 661 662 663",
    "talia@gmail.com",
    "fecha de nacimiento: 1973-04-10. color favorito: rojo pasión",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5876,
    "",
    "Terpsícore",
    3,
    2,
    "mujer israelita de 29 años, de buena apariencia aun no siendo demasiado guapa",
    "cuerpo regularcillo, algo fofo",
    "impresionantes pechos, si bien no muy firmes",
    "algo modosita y muy púdica en el sexo",
    "Skype: terpsicore1973; Badoo: terpsicore1973; Instagram: terpsicore1973",
    "",
    0,
    "(+972) 50 62 03 082",
    "terpsicore@gmail.com",
    "número de la suerte: 15",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5877,
    "",
    "Urania",
    4,
    2,
    "chica alemana (19 años), de muy buen ver y muy guapa",
    "buen cuerpo, delgadito y fibrado",
    "pechos algo pequeños, muy firmes",
    "muy viciosilla para lo joven que es",
    "Badoo: koeniginUrania",
    "Urania Schmidt",
    0,
    "(+49) 160 17 37 946",
    "urania_schmidt@gmail.com",
    "fecha de nacimiento: 1999-02-05",
    2
);

/*
 * sample data for tabla 'assignations'.
 * experiences: 8279 .. 8293.
 * lovers: 5869 .. 5877.
 */

INSERT INTO `myX`.`assignations` VALUES (8279, 5869);
INSERT INTO `myX`.`assignations` VALUES (8280, 5869);
INSERT INTO `myX`.`assignations` VALUES (8281, 5869); /* trio 1/4 */
INSERT INTO `myX`.`assignations` VALUES (8281, 5870);
INSERT INTO `myX`.`assignations` VALUES (8282, 5869); /* trio 2/4 */
INSERT INTO `myX`.`assignations` VALUES (8282, 5870);
INSERT INTO `myX`.`assignations` VALUES (8283, 5869);
INSERT INTO `myX`.`assignations` VALUES (8284, 5875);
INSERT INTO `myX`.`assignations` VALUES (8285, 5872);
INSERT INTO `myX`.`assignations` VALUES (8286, 5869);
INSERT INTO `myX`.`assignations` VALUES (8287, 5873);
INSERT INTO `myX`.`assignations` VALUES (8288, 5871);
INSERT INTO `myX`.`assignations` VALUES (8289, 5874);
INSERT INTO `myX`.`assignations` VALUES (8290, 5876);
INSERT INTO `myX`.`assignations` VALUES (8291, 5877);
INSERT INTO `myX`.`assignations` VALUES (8292, 5871); /* trio 3/4 */
INSERT INTO `myX`.`assignations` VALUES (8292, 5873);
INSERT INTO `myX`.`assignations` VALUES (8293, 5871); /* trio 4/4 */
INSERT INTO `myX`.`assignations` VALUES (8293, 5873);

/*
 * sample data for tabla 'queries'.
 */
INSERT INTO `myX`.`queries` VALUES (
    2,
    "todas las experiencias",
    "lista no filtrada de experiencias",
    "SELECT * FROM `myX`.`practica` WHERE `user` = 2",
    2
);

INSERT INTO `myX`.`queries` VALUES (
    3,
    "todos los amantes",
    "lista no filtrada de amantes",
    "SELECT * FROM `myX`.`amores` WHERE `user` = 2",
    2
);

INSERT INTO `myX`.`queries` VALUES (
    4,
    "todos los lugares",
    "lista no filtrada de lugares",
    "SELECT * FROM `myX`.`loca` WHERE `user` = 2",
    2
);

INSERT INTO `myX`.`queries` VALUES (
    5,
    "hoteles españoles",
    "lista de hoteles españoles en los que han habido experiencias sexuales",
    "SELECT * FROM `myX`.`loca` INNER JOIN `myX`.`countries` ON `myX`.`loca`.`country` = `myX`.`countries`.`countryID` INNER JOIN `myX`.`kinds` ON `myX`.`loca`.`kind` = `myX`.`kinds`.`kindID` WHERE (`countries`.`name` LIKE '%españa%' AND `kinds`.`name` LIKE '%hotel%') AND `loca`.`user` = 2",
    2
);

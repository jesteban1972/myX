/* myXData.sql
 * myX sample data
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-08
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
    1,                  /* GUILang */
    25,                 /* resultsPerPage */
    1,                  /* listsOrder */
    2                   /* userKind */
);

INSERT INTO `myX`.`users` VALUES (3,
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
    2);


INSERT INTO `myX`.`countries` VALUES (18, "Turquía", 2);
INSERT INTO `myX`.`countries` VALUES (19, "Grecia", 2);
INSERT INTO `myX`.`countries` VALUES (20, "Italia", 2);
/* values 1..17 reserved by Sarkodeiktes */

INSERT INTO `myX`.`kinds` VALUES (11, "(generic)", 2);
/* values 1..10 reserved by Sarkodeiktes */

INSERT INTO `myX`.`loca` VALUES(734, "", "Olimpia: Templo de Zeus", 3, "Archea Olimpia 270 65, Greece", 19, 11, "El templo de Zeus en Olimpia albergaba la famosa estatua crisoelefantina del dios, obra del no menos famoso Fidias. Esta estatua era considerada como una de las siete maravillas del mundo antiguo", "37.637932, 21.630238","37.637932, 21.630238", "odysseus.culture.gr", 2);
INSERT INTO `myX`.`loca` VALUES(735, "", "Delfos: Templo de Apolo", 3, "", 19, 11, "El templo de Apolo en Delfos era el lugar central del santuario y donde tenía lugar el famoso oráculo", "38.482288, 22.501146", "", "",2);
INSERT INTO `myX`.`loca` VALUES(736, "", "Éfeso: Templo de Artemisa", 3, "", 18, 11, "El templo de Artemisa en Éfeso era una de las siete maravillas del mundo antiguo", "37.949887, 27.363383", "", "", 2);
INSERT INTO `myX`.`loca` VALUES(737, "", "Atenas: Partenón", 3, "", 19, 11, "El Partenón de Atenas era una de las siete maravillas del mundo antiguo", "37.971482, 23.726625", "","",2);
INSERT INTO `myX`.`loca` VALUES(738, "", "Aphrodisias: Templo de Afrodita", 3, "Geyre Mahallesi, Kuyucak Tavas Yolu, 09385 Karacasu/Aydın, Turkey", 18, 11, "El templo de Afrodita es y sigue siendo el punto principal del sitio, pero el carácter del edificio se alteró cuando se convirtió en una basílica cristiana. Los escultores de Afrodisias eran célebres y se beneficiaron de una gran abundancia de mármol en las montañas cercanas. La escuela de escultura de la ciudad produjo bastantes obras, muchas de las cuales todavía se pueden apreciar en el sitio y en el museo de la ciudad. Durante las excavaciones se encontraron muchas estatuas completas en el área del ágora y estatuas sin terminar en un área que señala el sitio de una escuela de escultura. También se han hallado sarcófagos en varios puntos de la ciudad, la mayor parte de ellos con diseños que constan de guirnaldas y columnas, al igual que pilares con diseños descritos como «manuscritos humanos» o «vivientes», representando personas, pájaros y animales envueltos en hojas de acanto.<br />En el sitio arqueológico alrededor del templo se pueden encontrar rincones ideales para mantener sexo.", "37.710071, 28.725108", "", "www.muze.gov.tr/aphrodisias", 2);
INSERT INTO `myX`.`loca` VALUES(739, "", "Sunio: Templo de Poseidón", 3, "Cape Sounio, Sounio 195 00", 19, 11, "El templo de Poseidón de Sunio era lo primero que veían los navegantes cuando se aproximaban al Ática", "37.650153, 24.024572", "", "", 2);
INSERT INTO `myX`.`loca` VALUES(740, "", "Monte Cyllene: Templo de Hermes", 3, "", 19, 11, "El templo de Hermes en el Monte Cyllene se construyó en el lugar en que, según la tradición, nació el dios", "37.939785, 22.395832", "", "", 2);
INSERT INTO `myX`.`loca` VALUES(741, "", "Argos: Templo de Hera", 3, "", 19, 11, "El templo de Hera en Argos bla bla bla", "37.691998, 22.775001", "", "" ,2);
INSERT INTO `myX`.`loca` VALUES(742, "", "Roma: Templo de Marte Ultore", 3, "", 20, 11, "El templo de Marte Ultore en Roma bla bla bla", "41.894396, 12.486927", "", "", 2);
INSERT INTO `myX`.`loca` VALUES(743, "", "Atenas: Templo de Hefesto (aka Thisio)", 3, "Athens 105 55, Greece", 19, 11, "El templo de Hefesto en Atenas, erróneamente llamado Thisio, bla bla bla", "37.975588, 23.721417", "", "", 2);
INSERT INTO `myX`.`loca` VALUES(744, "", "Naxos: Templo de Démeter", 3, "", 19, 11, "El templo de Démeter en Naxos bla bla bla..", "37.029108, 25.431321", "", "" ,2);
INSERT INTO `myX`.`loca` VALUES(745, "", "Naxos: Templo de Dionisio", 3 ,"", 19, 11, "El templo de Dionisio en Naxos bla bla bla..", "37.077697, 25.380779", "", "", 2);
/* values 1..733 reserved by Sarkodeiktes */

INSERT INTO `myX`.`practica` VALUES (8279, "", "excitante coito activo con eyaculación", 4, 0, 734, "2018-01-01", "", "Primera experiencia, «ἐν πορνείῳ». Con Actea (Proto?), una hieródula del templo de Afrodita en Corinto, llegó el estreno.<br />aconteció que, tras verla en la estoa del templo y seducido por su buen aspecto no dudé en ir tras ella y abordarle, antes de que alguna otra «rapaz» me quitase la presa. fue fácil; no dudó mucho en venirse conmigo. fuimos al fornix que ella frecuenta, y echamos un polvo «de película». a causa de la calidad del género que tenía entre manos, yo estaba excitadísimo, y ella respondía muy, pero que muy bien. besaba como nadie y también felaba muy bien.<br />lo mejor fue cuando copulamos: ella estaba tumbada boca arriba. se abrió de piernas y sin ningún esfuerzo se lo introduje. una vez con el miembro dentro de su vagina no me importó follarla un poco, aunque sin eyacular dentro. y así lo hice. con lo abierta que estaba, no tuve ninguna dificultad en metérsela hasta los testículos, haciéndole estremecerse de placer.<br />yo daba sacudidas salvajes contra su vagina muriéndome de gusto, y ella disfrutaba «como una perra», aunque la muy «cabrona» ni se tocaba; me tocaba a mí, y a veces me tocaba los testículos y la raíz del miembro para cerciorarse de que lo tenía dentro.<br />me dio mucha pena tener que sacarla cuando estaba cerca de eyacular. me masturbé salvajemente, hasta «descargar» envuelto en un inmenso placer. ella tardó bastante tiempo más en llegar al orgasmo. al principio le estimulaba yo el clítoris, y al ver que no se acababa nunca le dije que lo hiciese ella misma, y mientras tanto yo le besaba, le acariciaba los pechos y le introducía un dedo por el ano. al final llegó al orgasmo entre espasmos de placer.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8280, "", "coito activo con eyaculación", 3, 0, 734, "2018-01-02", "", "esta es la experiencia número dos, experiencia vivida con XXX.<br />el sexo fué de lo más gratificante. cómodos y límpios, en una cama grande, me trató con delicadeza y dulzura. nos besamos, nos acariciamos tiérnamente. todo fué muy tierno aunque eso no quitó de disfrutar de lo más duro y placentero del sexo.<br />me propuso que la penetrase, y yo acepté nervioso. me puse timidamente el preservativo y, afortunadamente, debido a su experiencia, todo fué «sobre ruedas». se la metí de golpe, y ella se estremeció de placer. fué superexcitante.<br />no eyaculé dentro -eso hubiera sido perfecto-, pero disfrute como nunca lo habría imaginado.<br />cuando se fué me quedé completamente colado por ella.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8281, "", "coito activo con eyaculación", 3, 0, 734, "2018-01-03", "", "trío con XXX1 y XXX2. fue fantástico: me lo ligué con la mirada en ... . XXX1 no estaba muy convencido de ella, aunque a mí me gustaba bastante. «llevárnosla» fue muy fácil, pues en la puerta de ... le propusimos venirse con nosotros, y ella aceptó sin pensárselo.<br />fuimos con el coche a una calle sin salida, justo detrás de... . paré con el coche mirando hacia la salida, y puse el quitasol en el parabrisas. acto seguido nos pasamos a la parte de atrás, dejando a la chica en medio; me quité las botas, y no perdimos el tiempo:<br />comenzamos a besuquearnos y a acariciarnos a tres bandas, la chica respondía muy bien; nosotros dos también. nos fuimos desnudando gradualmente, y así pudimos contemplar su cuerpo en línea y su ... . una vez desnudos vimos que la chiquilla no se andaba con remilgos: a mí me felaba el miembro, mientras le daba el culo a XXX1. primero me la chupó a mí. después se dio la vuelta y ... a XXX1, y XXX1 le hizo un cunnilingus. siguió XXX2 chupando a XXX1...<br />entonces yo aproveché para ir trabajándole el clítoris. cuando pasó un rato XXX1 me vio las intenciones y le dijo: «<cite>¿Quieres que mi novio te meta la punta?</cite>», a lo que ella respondió: «<cite>Sin condón, no</cite>». entonces le dijimos: «<cite>Tenemos condones de sobra</cite>», mientras yo ya estaba cogiendo uno de mi pantalón.<br />me lo puse en el miembro, y empecé con las maniobras de penetración, aunque enseguida me di cuenta de que no iba a ser demasiado fácil. entonces me escurrí por debajo suya y empecé a lamer su culete, lo que parece que le dio mucho gusto a juzgar por los gemidos que daba. yo pensaba: «<cite>¡Cuando te meta el miembro te va a gustar todavía más!</cite>» enseguida me incorporé y retomé las maniobras, justo donde las había dejado, alcanzando con éxito la penetración anal completa en pocos segundos.<br />su cuerpo empezó a destensarse, y comenzamos a gozar. le fui dando sacudidas profundas, pero no muy fuertes, pues lo que yo quería era preparar esa conducto estrecho para que todos sintiéramos placer. la chavala emitía unos sonidos lastimeros, mezcla de placer y, al principio, de dolor; pero todo el dolor se transformó rápidamente en placer, y mi miembro entraba y salía de su culete con facilidad. XXX2 daba entonces profundos suspiros, envuelta en placer. XXX1 se masturbaba mientras la acariciaba y, a veces, ... .<br />... al tener la boca libre nos hizo notar aún más lo bien que lo estaba pasando, pues sus gemidos y suspiros eran continuos...", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8282, "", "coito activo con eyaculación", 3, 0, 734, "2018-01-04", "", "no tuve que trabajar mucho para beneficiármela, fue un regalo del cielo. al contrario, me pilló casi por sorpresa. a ella le bastó echar un ojo al interior de mi fornix, donde estaba yo tendido desnudo, para quedarse atento a mi reacción, la cual no se hizo de esperar.<br />entró inmediatamente, y yo empecé a comerle los pezones y a deleitarme del tamaño y la dureza de su pecho. simultáneamente, comencé a explorar lo que había mas abajo de la cintura, bajo la toalla, y descubrí con mucho gusto ...<br />πὼ πώ, ¡Dios qué tiaza! me la comí viva por todas partes, intentando disfrutar lo más posible de esos momentos que normalmente no se presentan cada día. ella se mostró más fría, y no sólo no me comió en el cuerpo, sino que evitó incluso el besarme; eso no quita que disfrutase también ella como un enano de mi cuerpo serrano.<br />al poco rato de «marraneo» me di cuenta de que se dejaba trabajar el culo más de lo normal. por supuesto ella ya había reparado en el tamaño y la dureza de mi miembro, y me hizo ver claramente que quería que le metiese «caña de España». se me dio la vuelta, me puso su culo en pompa y me largó un condón (que había traído consigo).<br />se la clavé profundamente. me la follé durante un buen rato, y mientras la follaba recorría con mis manos y mi boca su cuerpo de Venus. ella se sometía sumisamente a los viajes de mi pene erecto, y comprobaba de cuando en cuando la placentera presencia de mi miembro en su ojete. cambiamos dos veces de postura, y acabamos finalmente la cópula estando ella tumbada boca arriba, lo cual me dio la oportunidad de disfrutar plenamente de la contemplación de su cuerpazo mientras la follaba, y aún deleitarme de la caricia fogaz de su pecho terso.<br />en estas condiciones hubiera sido difícil no eyacular, lo cual hice encantado haciéndole ver abiertamente de qué modo gozaba. al momento me estaba haciendo un gesto de dolor para que se la sacara del culo, tan fría como ella misma lo había sido durante todo el rato.<br />fue apoteósico. magnífico. maravilloso. un polvo para no olvidar.<br />ella se comportó como una «cabrona» folladora, tan fría, tan bien equipada, tan sumisa... yo me comporté como un «cabrón» follador, tan sintabúes, tan dominante, tan «<i>yo me corro; tú haz lo que quieras</i>». comprensión total. disfrute pleno.<br />me pedía después del polvo que encendiese la luz: «<cite>Es ist ein Bisschen dunkel hier, oder?</cite>» quería ver con detalle al toro que se la había follado. la impresión debió resultar -espero- positiva. sin embargo, para no variar, siguió comportándose tan fríamente como lo había hecho todo el rato, y se largó al momento con un simple «<i>Tschüß</i>».<br />no importa. el disfrute que tuve con la cópula me había dejado totalmente satisfecho... y casi exhausto.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8283, "", "coito activo en trío con eyaculación", 3, 0, 734, "2018-01-05", "", "se lo estaban montando con mucha calma a la espera de un tercer vértice para el triángulo. entonces aparecí yo.<br />después de un rato no corto de «marraneo» inicial copulé con ambas; empecé por la que parecía más joven, y durante un rato bastante grande le penetré con fuerza y ganas.<br />después la otra, envidiosa, le dijo que ella también quería, por lo que cambiaron, y me follé a la otra con la fuerza de un toro salvaje. la «cabrona» disfrutó como una «puta perra», y los gritos que daban no parecían ser humanos.<br />después del polvo (ambas se corrieron, yo no), «flipaban» entre ellas de ver cómo me las había follado. me miraban y sonreían. yo estaba bañado en sudor.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8284, "", "coito activo con eyaculación", 3, 0, 734, "2018-01-06", "", "la segunda vez con ella -por cierto, ella no me reconoció-, no hizo falta demasiado flirteo para comprender nuestras intenciones: nos deseábamos.<br />entré en ... ; me siguió; nos enrollamos de inmediato. con mucho frenesí nos comimos la boca, nos estrujamos, «nos dimos caña». la manoseé viva, y ella hizo lo mismo conmigo. me feló el miembro (en bastantes ocasiones) haciéndome un «<i>deep-throat</i>» tan regular y bien hecho que llegó a asombrarme. le trabajé el clítoris a base de bien. πὼ πώ, ¡qué bueno!<br />después de un rato de trajineo en ese «agujero del placer» me la follé viva un montón de ocasiones, utilizando para ello nada menos que cuatro condones diferentes. y entre clavada y clavada «marraneábamos», nos comíamos las bocas.<br />asumo que acabé eyaculando.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8285, "", "coito activo con eyaculación", 3, 0, 734, "2018-01-07", "", "nos enrollamos en un rincón oscuro; luego fuimos a un fornix.<br />se puso hecha una «zorra», me manoseó y me comió vivo. se mediodesnudó, se arrodilló ante mí, y me la comió enteretita.<br />mientras, yo ya le había estado palpando el ano: follastible. seguí durante un rato «trabajándole» el culete; ella con la <i>fellatio</i>. así que, al poco rato, se ofreció a ser follada. ante mi respuesta afirmativa, se terminó de desnudar, se colocó en el <i>sling</i>, se abrió de piernas.<br />le clavé la punta de mi miembro en su ano abierto y, en lugar de follarlo, hice balancear muy despacito el <i>sling</i> de modo que mi pene le entraba y salía muy, muy despacio, disfrutando al máximo su culete en cada milímetro de mi miembro tieso. πὼ πώ, ¡fué totalmente «<i>geil</i>»! entonces le pregunté si le gustaba más de esa manera o de... «<cite>¡Ésta!</cite>», dije, mientras se la clavava con la fuerza de un toro salvaje. le encantó, a la «zorra». me dijo que era un buen follador. le estuve metiendo embestidas un buen rato...<br />me había pedido que eyaculase en sus pechos, y había llegado el momento. se la saqué, rodeé el <i>sling</i> y se la metí en la boca, que la tenía abierta con la cabeza girada hacia atrás. <i>deep throat</i>. tanto, que hasta me dolía.<br />al ratito se la saqué y, masturbándome frenéticamente, eyaculé descargando toda mi virilidad en su barbilla, cuello y pechos. entonces llegó ella al orgasmo, masturbándose.<br />le encantó, a la «perra». se quedó flipando. no paró de elogiarme.<br /><i>intermission...</i>", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8286, "", "experience", 3, 0, 734, "2018-01-08", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8287, "", "experience", 3, 0, 735, "2018-01-09", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8288, "", "experience", 3, 0, 735, "2018-01-10", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8289, "", "experience", 3, 0, 735, "2018-01-11", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8290, "", "experience", 3, 0, 735, "2018-01-12", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8291, "", "experience", 3, 0, 735, "2018-01-13", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8292, "", "experience", 3, 0, 735, "2018-01-14", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8293, "", "experience", 3, 0, 735, "2018-01-15", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8294, "", "experience", 3, 0, 735, "2018-01-16", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8295, "", "experience", 3, 0, 736, "2018-01-17", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8296, "", "experience", 3, 0, 736, "2018-01-18", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8297, "", "experience", 3, 0, 736, "2018-01-19", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8298, "", "experience", 3, 0, 736, "2018-01-20", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8299, "", "experience", 3, 0, 736, "2018-01-21", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8300, "", "experience", 3, 0, 736, "2018-01-22", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8301, "", "experience", 3, 0, 736, "2018-01-23", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8302, "", "experience", 3, 0, 736, "2018-01-24", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8303, "", "experience", 3, 0, 737, "2018-01-25", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8304, "", "experience", 3, 0, 737, "2018-01-26", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8305, "", "experience", 3, 0, 737, "2018-01-27", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8306, "", "experience", 3, 0, 737, "2018-01-28", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8307, "", "experience", 3, 0, 737, "2018-01-29", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8308, "", "experience", 3, 0, 737, "2018-01-30", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8309, "", "experience", 3, 0, 737, "2018-01-31", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8310, "", "experience", 3, 0, 737, "2018-02-01", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8311, "", "experience", 3, 0, 738, "2018-02-02", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8312, "", "experience", 3, 0, 738, "2018-02-03", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8313, "", "experience", 3, 0, 738, "2018-02-04", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8314, "", "experience", 3, 0, 738, "2018-02-05", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8315, "", "experience", 3, 0, 738, "2018-02-06", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8316, "", "experience", 3, 0, 738, "2018-02-07", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8317, "", "experience", 3, 0, 738, "2018-02-08", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8318, "", "experience", 3, 0, 738, "2018-02-09", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8319, "", "experience", 3, 0, 738, "2018-02-10", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8320, "", "experience", 3, 0, 739, "2018-02-11", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8321, "", "experience", 3, 0, 739, "2018-02-12", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8322, "", "experience", 3, 0, 739, "2018-02-13", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8323, "", "experience", 3, 0, 739, "2018-02-14", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8324, "", "experience", 3, 0, 739, "2018-02-15", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8325, "", "experience", 3, 0, 739, "2018-02-16", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8326, "", "experience", 3, 0, 739, "2018-02-17", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8327, "", "experience", 3, 0, 739, "2018-02-18", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8328, "", "experience", 3, 0, 739, "2018-02-19", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8329, "", "experience", 3, 0, 740, "2018-02-20", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8330, "", "experience", 3, 0, 740, "2018-02-21", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8331, "", "experience", 3, 0, 740, "2018-02-22", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8332, "", "experience", 3, 0, 740, "2018-02-23", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8333, "", "experience", 3, 0, 740, "2018-02-24", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8334, "", "experience", 3, 0, 740, "2018-02-25", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8335, "", "experience", 3, 0, 740, "2018-02-26", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8336, "", "experience", 3, 0, 740, "2018-02-27", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8337, "", "experience", 3, 0, 741, "2018-02-28", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8338, "", "experience", 3, 0, 741, "2018-03-01", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8339, "", "experience", 3, 0, 741, "2018-03-02", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8340, "", "experience", 3, 0, 741, "2018-03-03", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8341, "", "experience", 3, 0, 741, "2018-03-04", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8342, "", "experience", 3, 0, 741, "2018-03-05", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8343, "", "experience", 3, 0, 741, "2018-03-06", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8344, "", "coito activo con eyaculación", 3, 0, 742, "2018-03-07", "", "después del «marraneo» inicial, y viendo que se dejaba «trajinar» bien, me la follé con relativa facilidad. se puso muy «puta»; se doblaba cual bisagra, y se abría los labios vaginales para que le entrase más adentro. yo no quería correrme todavía, por lo cual al ratito se la saqué.<br />sin embargo la «cabrona» consiguió mantenerme caliente con sus calientes felaciones, y al rato se la estaba metiendo de nuevo en las mismas condiciones de antes. pasado un rato decidí dejarlo estar.<br />ella, sin embargo, no se resistía a acabar con el asunto, así que me la chupaba una y otra vez. comprendí sus intenciones inmediatamente. le agarré la cabeza y le follé la boca durante un ratito, hasta que eyaculé dentro.<br />la «cabrona», en cambio, no se corrió. fue más lista que yo.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8345, "", "experience", 3, 0, 742, "2018-03-08", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8346, "", "experience", 3, 0, 742, "2018-03-09", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8347, "", "experience", 3, 0, 742, "2018-03-10", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8348, "", "experience", 3, 0, 742, "2018-03-11", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8349, "", "coito activo con eyaculación", 3, 0, 742, "2018-03-12", "", "la conquisté con la táctica de la hormiga león, y al momento le estaba dando «caña de España».<br />casi inmediatamente empecé a trabajarle el chochete, cerciorándome de que lo tenía accesible. le di entonces la vuelta, la doblé y se la clavé sin apenas dificultades. le trajiné el culete bastante bien, y mis salvajes sacudidas debieron de gustarle.<br />a mí me dio tanto placer ese «ojete de XXX», que al poco rato me estaba corriendo en mis últimos «viajes». una vez hube acabado y se la hube sacado del culo se largó, satisfecha, sin mediar palabra.<br /><i>intermission...</i>", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8350, "", "experience", 3, 0, 742, "2018-03-13", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8351, "", "experience", 3, 0, 742, "2018-03-14", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8352, "", "experience", 3, 0, 743, "2018-03-15", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8353, "", "coito activo sin eyaculación", 3, 0, 743, "2018-03-16", "", "fue muy, muy «puta»: nada más percatarse que iba a por ella, al entrar yo en la cabina, sin mediar palabra ni gestos, comenzó a desnudarse. se quitó todo lo de abajo, dejándose la camiseta, y a continuación se tumbó en el <i>sling</i>. yo había aprovechado para manosearla mientras se desnudaba, pero ella no quería «marraneo», sino sólo follada.<br />así que, tumbado de patas abiertas, esnifó <i>poppers</i> y me dijo: «<cite>¡Fóllame!</cite>». aproveche para tomar de su <i>poppers</i>, me puse caliente, y la penetré sin dificultad alguna. aproveché para «manosear» lo que pude su cuerpo, y le estrujé sus pechos. πὼ πώ, ¡estaba buena, la «cabrona»!<br />le gustó, a la «perra». al cabo de un rato me dijo que no podía mas, así que se la saqué y le hice que me la felase durante un buen rato. me dijo que podía eyacular en su boca; estaba deseando que lo hiciera. me masturbaba frenéticamente la raíz del miembro mientras que con la lengua fuera de la boca chupaba el glande.<br />me puse muy caliente. tanto, que sentí la necesidad de volver a «clavársela»… lo cual hice, proporcionándole a ella y a mí mismo nuevos placeres «chechuales». más cópula, más pellizcos en los pezones, más «trajineo» de los pechos...<br />me incitó nuevamente a que me corriese, lo cual *NO* deseaba hacer.<br />al final, habiendo visto ella que yo no estaba dispuesto a acabar, me dijo que de verdad no podía mas, por lo que lo acabamos dejando.<br /><i>intermission...</i>", 4, 1,2);
INSERT INTO `myX`.`practica` VALUES (8354, "", "experience", 3, 0, 743, "2018-03-17", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8355, "", "experience", 3, 0, 743, "2018-03-18", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8356, "", "coito anal activo con eyaculación", 3, 0, 743, "2018-03-19", "", "como tenía ganas de «beneficiármela» (más que nada para satisfacer mi curiosidad), esa noche me la trabajé un poco -no demasiado-, y me la llevé a la cama.<br />después de los preámbulos (¡una forma ridícula de besar!), que con el «derroche» de <i>sex-appeal</i> suyo no se realizaron demasiado satisfactoriamente, me la manejé hasta ponérmelo «a tiro», y me la «trinqué» por detrás. a pesar de las lógicas dificultades iniciales, con la ayuda de crema lubricante al poco ratito entraba con facilidad. intenté follármela salvajemente para dejarla satisfecho, que no quedase decepcionada del «producto nacional».<br />y aunque un ratito muy satisfactoriamente la porculeé, al rato me di cuenta de que no la tenía todo lo dura que debiese, con lo que decidí acabar con la porculada (recuerdo a la pobre con el culo «en pompa» y, esperando una nueva embestida, darse cuenta que la «inyección» había acabado).<br />se supone que el polvo acabó en corrida.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8357, "", "experience", 3, 0, 743, "2018-03-20", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8358, "", "experience", 3, 0, 743, "2018-03-21", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8359, "", "experience", 3, 0, 743, "2018-03-22", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8360, "", "Coito activo con eyaculación", 3, 0, 744, "2018-03-23", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8361, "", "experience", 3, 0, 744, "2018-03-24", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8362, "", "coito activo en trío con eyaculación", 3, 0, 744, "2018-03-25", "", "sin grandes preámbulos nos enrollamos con la chica sin inhibiciones, y nos chupamos y «marraneamos» bastante.<br />cuando observamos la apertura de su esfinter anal, y comprendimos que estaba pidiendo «pija» a gritos, nos retiramos a un lugar más apartado, e íntimamente, sin interrupciones por fortuna, nos la follamos repetidas veces, y alternadamente, Mario y yo, todo entre fellatio y cunnilingus.<br />en una de estas Mario se corrió en su culito. yo prohibí a XXX que se corriera, con el deseo <i>expresis verbis</i> de follarle también yo, e inundar su culo de leche.<br />dicho y hecho: relevé a Mario, que exhausto se retiraba a observar, y arremetí contra la abierta vagina de XXX, a la cual propicié varios viajes que nos hacían corrernos placenteramente al unísono.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8363, "", "Juego carnal con eyaculación", 3, 0, 744, "2018-03-26", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8364, "", "Coito activo sin eyaculación", 3, 0, 744, "2018-03-27", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8365, "", "experience", 3, 0, 744, "2018-03-28", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8366, "", "experience", 3, 0, 744, "2018-03-29", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8367, "", "Fellatio pasiva con eyaculación", 3, 0, 744, "2018-03-30", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8368, "", "experience", 3, 0, 745, "2018-03-31", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8369, "", "experience", 3, 0, 745, "2018-04-01", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8370, "", "experience", 3, 0, 745, "2018-04-02", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8371, "", "coito activo sin eyaculación", 3, 0, 745, "2018-04-03", "", "nada más acercame a ella en la puerta del local se abalanzó sobre mí como un loco, con una pasión desenfrenada. nos comimos vivos, me la estuvo chupando un buen rato, y disfrutamos bastante de nuestros cuerpos.<br />cuando me decidí a «trajinarle» el culete, casi al momento me di cuenta de que la «cabrona» estaba más que abierta. entonces, viendo ella la dureza de mi miembro, se me puso «superperra», se dio la vuelta y quiso que se la clavase así, sin más, y allí mismo. tuve que pararla para colocar profilaxis, pero al momento se la estaba clavando en el culete con toda la facilidad del mundo mientras ella, doblada como una bisagra, disfrutaba de mi polla dura.<br />me la follé viva. incluso esnifé <i>poppers</i> de mi primera flamante botella que había comprado. ella me agarraba frenéticamente y me empujaba hacia sí, para clavársela más profundamente.<br />durante un buen rato estuvimos follando. revoloteaban «moscones» que teníamos que apartar. a mí se me bajó un poco la dureza. decidí sacársela y, mientras me masturbaba, seguí «trabajándole» el ano con un dedo. se me volvió a poner superdura, y pensé en volver a clavársela. pero en estas la «cabrona» se corrió, y ahí quedó la cosa.", 4, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8372, "", "experience", 3, 0, 745, "2018-04-04", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8373, "", "experience", 3, 0, 745, "2018-04-05", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8374, "", "experience", 3, 0, 745, "2018-04-06", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8375, "", "experience", 3, 0, 745, "2018-04-07", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8376, "", "experience", 3, 0, 734, "2018-04-08", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8377, "", "experience", 3, 0, 734, "2018-04-09", "", "Lorem ipsum", 3, 1, 2);
INSERT INTO `myX`.`practica` VALUES (8378, "", "Excitante coito activo con eyaculación", 4, 1, 734, "2018-04-20", "", "Con Eucranta, la que concede coronar el fin, terminan mis aventuras amorosas.<br />Ocurrió que...", 3, 1, 2);
/* values 1..8278 reserved by Sarkodeiktes */

INSERT INTO `myX`.`amores` VALUES (5869, "", "Actea, la de los acantilados", 3, 2, "Actea es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Actea es la de los acantilados", "Skype: actea1973; Badoo: actea1973; Instagram: actea1973", "Actea María Pérez Pérez", 0, "(+34) 661 662 663", "actea@gmail.com", "fecha de nacimiento: 1973-01-01", 2);
INSERT INTO `myX`.`amores` VALUES (5870, "", "Ágava, la resplandeciente", 3, 2, "Ágava es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Ágava es la resplandeciente", "", "Ágava Martínez Sánchez", 0, "(+34) XXX", "agava@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5871, "", "Amatea, la de hermosos bucles", 3, 2, "Amatea es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Amatea es la de hermosos bucles", "", "", 0, "(+34) XXX", "amatea@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5872, "", "Anfínoma", 3, 2, "Anfínoma es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Anfínoma es dócil, es respetuosa, es obediente, dulce, amorosa", "", "", 0, "(+34) XXX", "anfinoma@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5873, "", "Anfítoa", 3, 2, "Anfítoa es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Anfítoa es bipolar: O así, o asao", "", "", 0, "(+34) XXX", "XXX@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5874, "", "Anfítrite, la de bellos tobillos", 3, 2, "Anfítrite es así y asao", "Cuerpo tal y tal, sus tobillos son bellísimos", "Pecho tal y tal", "Amfítrite...", "", "", 0, "(+34) XXX", "anfitrite@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5875, "", "Apseudes", 3, 2, "Apseudes es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Apseudes es una persona sincera en grado sumo", "", "", 0, "(+34) XXX", "apseudes@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5876, "", "Autónoe, la que se entiende a sí misma", 3, 2, "Autónoe es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Autónoe es la (única?) que se entiende a sí misma", "", "", 0, "(+34) XXX", "autonoe@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5877, "", "Calianasa", 3, 2, "Calianasa es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Calianasa...", "", "", 0, "(+34) XXX", "calianasa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5878, "", "Calianira", 3, 2, "Calianira es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Calianira...", "", "", 0, "(+34) XXX", "calianira@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5879, "", "Calipso", 3, 2, "Calipso es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Calipso...", "", "", 0, "(+34) XXX", "calipso@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5880, "", "Ceto", 3, 2, "Ceto es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Ceto...", "", "", 0, "(+34) XXX", "ceto@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5881, "", "Cimatolega, la que calma el oleaje", 3, 2, "Cimatolega es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Cimatolega es tan mandona, que podría hasta calmar el oleaje del mar, si se lo propusiera", "", "", 0, "(+34) XXX", "cimatolega@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5882, "", "Cimo, la de las olas", 3, 2, "Cimo es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Cimo es la de las olas", "", "", 0, "(+34) XXX", "cimo@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5883, "", "Cimódoce, la que recibe las olas, la que calma sin esfuerzo el oleaje en el sombrío ponto y las rafagas de los vientos huracanados", 3, 2, "Cimódoce es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Cimódoce no sólo es la que recibe las olas, sino también la que calma sin esfuerzo el oleaje en el sombrío ponto y las rafagas de los vientos huracanados", "", "", 0, "(+34) XXX", "cimodoce@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5884, "", "Cimótoa, la de rápidas olas", 3, 2, "Cimótoa es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Cimótoa es la de rápidas olas", "", "", 0, "(+34) XXX", "cimotoa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5885, "", "Clímena", 3, 2, "Clímena es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Clímena...", "", "", 0, "(+34) XXX", "climena@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5886, "", "Clío", 3, 2, "Clío es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Clío no sólo es un coche, sino...", "", "", 0, "(+34) XXX", "clio@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5887, "", "Cranto", 3, 2, "Cranto así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Cranto...", "", "", 0, "(+34) XXX", "cranto@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5888, "", "Dero", 3, 2, "Dero es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Dero...", "", "", 0, "(+34) XXX", "dero@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5889, "", "Dexamena", 3, 2, "Dexamena es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Dexamena...", "", "", 0, "(+34) XXX", "dexamena@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5890, "", "Dinámena, la potente", 3, 2, "Dinámena es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Dinámena...", "", "", 0, "(+34) XXX", "dinamena@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5891, "", "Dione", 3, 2, "Dione es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Dione es la hija del Dioni", "", "", 0, "(+34) XXX", "dione@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5892, "", "Doris, la que regala", 3, 2, "Doris es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Doris es dadivosa", "", "", 0, "(+34) XXX", "doris@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5893, "", "Doto, la dadivosa", 3, 2, "Doto es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Doto, como Doris, también es dadivosa", "", "", 0, "(+34) XXX", "doto@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5894, "", "Érato, la deliciosa", 3, 2, "Érato es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Érato es deliciosa", "", "", 0, "(+34) XXX", "erato@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5895, "", "Espío, la de las grutas", 3, 2, "Espío es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Espío es la de las grutas", "", "", 0, "(+34) XXX", "espio@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5896, "", "Eucranta, la que concede coronar el fin", 3, 2, "Eucranta es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Eucranta concede coronar el buen film", "", "", 0, "(+34) XXX", "eucranta@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5897, "", "Eudora, la que da prosperidad", 3, 2, "Eudora es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Eudora es la que da prosperidad", "", "", 0, "(+34) XXX", "eudora@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5898, "", "Eulímene, la de buen puerto", 3, 2, "Eulímene es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Eulímene es la de buen puerto", "", "", 0, "(+34) XXX", "eulimene@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5899, "", "Eumolpe", 3, 2, "Eumolpe es así y asao", "Cuerpo tal y tal", "Pecho tal y tal", "Eumolpe...", "", "", 0, "(+34) XXX", "eumolpe@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5900, "", "Eunice, la de fácil victoria, la de rosados brazos", 3, 2, "Eunice es así y asao", "Tiene un cuerpo estupendo con sus rosados brazos", "Tiene un pecho tal y tal", "Eunice es la de fácil victoria porque fácilmente la conquisté", "", "", 0, "", "eunice@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5901, "", "Eupompa, la de feliz viaje", 3, 2, "Eupompa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Eupompa es la compañera ideal de viaje, la de feliz viaje, porque hace que todo viaje sea feliz", "", "", 0, "", "eupompa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5902, "", "Eurídice", 3, 2, "Eurídice es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "euridice@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5903, "", "Evágora,la elocuente", 3, 2, "Evágora es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Evágora es muy elocuente", "", "", 0, "", "evagora@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5904, "", "Evarna, la rica en ganado, la de encantadora figura y belleza sin tacha", 3, 2, "Evarna es una nereida cuya belleza es sin tacha", "Tiene un cuerpo maravilloso, de encantadora figura", "Tiene un pecho tal y tal", "Evarna es rica en ganado y, por tanto, un pelotazo en toda regla", "", "", 0, "", "evarna@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5905, "", "Éyone, la del fondeadero", 3, 2, "Éynoe es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Éyone es la del fondeadero", "", "", 0, "", "eyone@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5906, "", "Ferusa, la que lleva", 3, 2, "Ferusa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Ferusa es la que lleva, porque siempre quiere llevar", "", "", 0, "", "ferusa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5907, "", "Galatea, la hermosa, la muy ilustre", 3, 2, "Galatea es hermosa, muy hermosa", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Galatea es muy ilustre", "", "", 0, "", "galatea@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5908, "", "Galena, la calma", 3, 2, "Galena es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Galena es muy calmada, es la viva imagen de la calma", "", "", 0, "", "galena@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5909, "", "Glauca, la azulada", 3, 2, "Glauca es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Glauca es azulada", "", "", 0, "", "glauca@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5910, "", "Glaucónoma, la del azulado prado, la risueña", 3, 2, "Glaucónoma es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Glaucónoma es muy risueña, vive en los mundos de Yuppi, en un azulado prado", "", "", 0, "", "glauconoma@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5911, "", "Halía, la salada, la amable, la de inmensos ojos", 3, 2, "Halía es así y asao, tiene unos ojos inmensos", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Halía es muy salada a la par que amable", "", "", 0, "", "halia@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5912, "", "Halimeda, la que cuida del mar, la de bella corona", 3, 2, "Halimeda es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Halimeda tiene una bella corona, y cuida diligentemente del mar", "", "", 0, "", "halimeda@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5913, "", "Hipónoe, la inteligente como un caballo, la de rosados brazos", 3, 2, "Hipónoe es así y asao", "Tiene un cuerpo tal y tal, con unos brazos rosados", "Tiene un pecho tal y tal", "Hipótoe es inteligente como un caballo", "", "", 0, "", "hiponoe@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5914, "", "Hipótoa, la veloz como un caballo, la encantadora", 3, 2, "Hipótoa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Hipótoa es encantadora y, además, es veloz como un caballo", "", "", 0, "", "hipotoa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5915, "", "Iera", 3, 2, "Iera es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", 3, "", "", "", "iera@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5916, "", "Laomedea, la que cuida del pueblo", 3, 2, "Laomedea es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Laomeda cuida del pueblo", "", "", 0, "", "", "laomedea@gmail.com", 2);
INSERT INTO `myX`.`amores` VALUES (5917, "", "Leágora, la de la suave palabra", 3, 2, "Leágora es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Leágora tiene una palabra suave", "", "", 0, "", "leagora@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5918, "", "Limnoria", 3, 2, "Limnoria es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "limnoria@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5919, "", "Lisiánasa, la señora de la libertad", 3, 2, "Lisiánasa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Lisiánasa es la señora de la libertad, es libre, le gusta ser libre", "", "", 0, "", "lisianasa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5920, "", "Mélita, la dulce, la graciosa", 3, 2, "Mélita es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Mélita es dulce, es graciosa", "", "", 0, "", "melita@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5921, "", "Menipa, la del vigor de caballo, la divina", 3, 2, "Menipa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Menipa es vigorosa, tiene el vigor de un caballo, es divina", "", "", 0, "", "menipa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5922, "", "Mera", 3, 2, "Mera es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "mera@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5923, "", "Nausítoe", 3, 2, "Nausítoe es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "nausitoe@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5924, "", "Nemertes, la sin tacha, la que tiene la inteligencia de su inmortal padre", 3, 2, "Nemertes es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Nemertes es la sin tacha, y tiene la inteligencia de su inmortal padre", "", "", 0, "", "nemertes@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5925, "", "Neómeris", 3, 2, "Neómeris es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "neomeris@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5926, "", "Nesea, la isleña", 3, 2, "Nesea es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Nesea es isleña", "", "", 0, "", "nesea@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5927, "", "Neso, la isla", 3, 2, "Neso es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Neso es llamada la isla porque es isleña", "", "", 0, "", "neso@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5928, "", "Oritía", 3, 2, "Oritía es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "oritia@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5929, "", "Pánopa, la que todo lo ve", 3, 2, "Pánopa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Pánopa es la que todo lo ve, no hay nada que le pase inadvertido", "", "", 0, "", "panopa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5930, "", "Pasítea, la muy divina", 3, 2, "Pasítea es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Pasítea es la muy divina", "", "", 0, "", "pasitea@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5931, "", "Plexaura", 3, 2, "Plexaura es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "plexaura@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5932, "", "Ploto, la naviera", 3, 2, "Ploto es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Ploto es la naviera porque le encanta navegar", "", "", 0, "", "ploto@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5933, "", "Polínoe, la que mucho entiende", 3, 2, "Polínoe es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Polínoe es la que mucho entiende, porque es muy inteligente", "", "", 0, "", "polinoe@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5934, "", "Polínome", 3, 2, "Polínome es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "polinome@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5935, "", "Pontomedusa", 3, 2, "Pontomedusa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "pontomedusa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5936, "", "Prónoe, la previsora", 3, 2, "Prónoe es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "pronoe@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5937, "", "Proto, la primera", 3, 2, "Proto es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Proto es la primera", "", "", 0, "", "proto@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5938, "", "Protomedea, la primera en pensamientos", 3, 2, "Protomedea es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Protomedea es la primera en pensamientos", "", "", 0, "", "protomedea@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5939, "", "Protoporea, la que permite atravesar el ponto", 3, 2, "Protoporea es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Protoporea permite atravesar el ponto", "", "", 0, "", "protoporea@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5940, "", "Psámata, la arenosa, la de gracioso porte", 3, 2, "Psámata es así y asao", "Psámata tiene un gracioso porte", "Tiene un pecho tal y tal", "Psámata *NO* es mentirosa, es arenosa", "", "", 0, "", "psamata@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5941, "", "Sao, la salvadora", 3, 2, "Sao es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Sao es salvadora", "", "", 0, "", "sao@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5942, "", "Talía", 3, 2, "Talía es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "talia@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5943, "", "Temisto, la observadora de las leyes divinas", 3, 2, "Temisto es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "Temisto es observadora de las leyes divinas", "", "", 0, "", "temisto@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5944, "", "Tetis", 3, 2, "Tetis es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "tetis@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5945, "", "Toa, la rápida", 3, 2, "Toa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "toa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5946, "", "Yanasa", 3, 2, "Yanasa es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "yanasa@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5947, "", "Yanira", 3, 2, "Yanira es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "yanira@gmail.com", "", 2);
INSERT INTO `myX`.`amores` VALUES (5948, "", "Yone", 3, 2, "Yone es así y asao", "Tiene un cuerpo tal y tal", "Tiene un pecho tal y tal", "", "", "", 0, "", "yone@gmail.com", "", 2);
/* values 1..5868 reserved by Sarkodeiktes */

INSERT INTO `myX`.`assignations` VALUES (8279, 5869);
INSERT INTO `myX`.`assignations` VALUES (8280, 5870);
INSERT INTO `myX`.`assignations` VALUES (8281, 5871);
INSERT INTO `myX`.`assignations` VALUES (8282, 5872);
INSERT INTO `myX`.`assignations` VALUES (8283, 5873); /* trio 1/2 */
INSERT INTO `myX`.`assignations` VALUES (8283, 5874); /* trio 2/2 */
INSERT INTO `myX`.`assignations` VALUES (8284, 5874);
INSERT INTO `myX`.`assignations` VALUES (8285, 5875);
INSERT INTO `myX`.`assignations` VALUES (8286, 5876);
INSERT INTO `myX`.`assignations` VALUES (8287, 5877);
INSERT INTO `myX`.`assignations` VALUES (8288, 5878);
INSERT INTO `myX`.`assignations` VALUES (8289, 5879);
INSERT INTO `myX`.`assignations` VALUES (8290, 5880);
INSERT INTO `myX`.`assignations` VALUES (8291, 5881);
INSERT INTO `myX`.`assignations` VALUES (8292, 5882);
INSERT INTO `myX`.`assignations` VALUES (8293, 5883);
INSERT INTO `myX`.`assignations` VALUES (8294, 5884);
INSERT INTO `myX`.`assignations` VALUES (8295, 5885);
INSERT INTO `myX`.`assignations` VALUES (8296, 5886);
INSERT INTO `myX`.`assignations` VALUES (8297, 5887);
INSERT INTO `myX`.`assignations` VALUES (8298, 5888);
INSERT INTO `myX`.`assignations` VALUES (8299, 5889);
INSERT INTO `myX`.`assignations` VALUES (8300, 5900);
INSERT INTO `myX`.`assignations` VALUES (8301, 5901);
INSERT INTO `myX`.`assignations` VALUES (8302, 5902);
INSERT INTO `myX`.`assignations` VALUES (8303, 5903);
INSERT INTO `myX`.`assignations` VALUES (8304, 5904);
INSERT INTO `myX`.`assignations` VALUES (8305, 5905);
INSERT INTO `myX`.`assignations` VALUES (8306, 5906);
INSERT INTO `myX`.`assignations` VALUES (8307, 5907);
INSERT INTO `myX`.`assignations` VALUES (8308, 5908);
INSERT INTO `myX`.`assignations` VALUES (8309, 5909);
INSERT INTO `myX`.`assignations` VALUES (8310, 5910);
INSERT INTO `myX`.`assignations` VALUES (8311, 5911);
INSERT INTO `myX`.`assignations` VALUES (8312, 5912);
INSERT INTO `myX`.`assignations` VALUES (8313, 5913);
INSERT INTO `myX`.`assignations` VALUES (8314, 5914);
INSERT INTO `myX`.`assignations` VALUES (8315, 5915);
INSERT INTO `myX`.`assignations` VALUES (8316, 5916);
INSERT INTO `myX`.`assignations` VALUES (8317, 5917);
INSERT INTO `myX`.`assignations` VALUES (8318, 5918);
INSERT INTO `myX`.`assignations` VALUES (8319, 5919);
INSERT INTO `myX`.`assignations` VALUES (8320, 5920);
INSERT INTO `myX`.`assignations` VALUES (8321, 5921);
INSERT INTO `myX`.`assignations` VALUES (8322, 5922);
INSERT INTO `myX`.`assignations` VALUES (8323, 5923);
INSERT INTO `myX`.`assignations` VALUES (8324, 5924);
INSERT INTO `myX`.`assignations` VALUES (8325, 5925);
INSERT INTO `myX`.`assignations` VALUES (8326, 5926);
INSERT INTO `myX`.`assignations` VALUES (8327, 5927);
INSERT INTO `myX`.`assignations` VALUES (8328, 5928);
INSERT INTO `myX`.`assignations` VALUES (8329, 5929);
INSERT INTO `myX`.`assignations` VALUES (8330, 5930);
INSERT INTO `myX`.`assignations` VALUES (8331, 5931);
INSERT INTO `myX`.`assignations` VALUES (8332, 5932);
INSERT INTO `myX`.`assignations` VALUES (8333, 5933);
INSERT INTO `myX`.`assignations` VALUES (8334, 5934);
INSERT INTO `myX`.`assignations` VALUES (8335, 5935);
INSERT INTO `myX`.`assignations` VALUES (8336, 5936);
INSERT INTO `myX`.`assignations` VALUES (8337, 5937);
INSERT INTO `myX`.`assignations` VALUES (8338, 5938);
INSERT INTO `myX`.`assignations` VALUES (8339, 5939);
INSERT INTO `myX`.`assignations` VALUES (8340, 5940);
INSERT INTO `myX`.`assignations` VALUES (8341, 5941);
INSERT INTO `myX`.`assignations` VALUES (8342, 5942);
INSERT INTO `myX`.`assignations` VALUES (8343, 5943);
INSERT INTO `myX`.`assignations` VALUES (8344, 5944);
INSERT INTO `myX`.`assignations` VALUES (8345, 5945);
INSERT INTO `myX`.`assignations` VALUES (8346, 5946);
INSERT INTO `myX`.`assignations` VALUES (8347, 5947);
INSERT INTO `myX`.`assignations` VALUES (8348, 5948); /* max amorID */
INSERT INTO `myX`.`assignations` VALUES (8349, 5948);
INSERT INTO `myX`.`assignations` VALUES (8350, 5948);
INSERT INTO `myX`.`assignations` VALUES (8351, 5948);
INSERT INTO `myX`.`assignations` VALUES (8352, 5948);
INSERT INTO `myX`.`assignations` VALUES (8353, 5948);
INSERT INTO `myX`.`assignations` VALUES (8354, 5948);
INSERT INTO `myX`.`assignations` VALUES (8355, 5948);
INSERT INTO `myX`.`assignations` VALUES (8356, 5948);
INSERT INTO `myX`.`assignations` VALUES (8357, 5948);
INSERT INTO `myX`.`assignations` VALUES (8358, 5948);
INSERT INTO `myX`.`assignations` VALUES (8359, 5948);
INSERT INTO `myX`.`assignations` VALUES (8360, 5948);
INSERT INTO `myX`.`assignations` VALUES (8361, 5948);
INSERT INTO `myX`.`assignations` VALUES (8362, 5948);
INSERT INTO `myX`.`assignations` VALUES (8363, 5948);
INSERT INTO `myX`.`assignations` VALUES (8364, 5948);
INSERT INTO `myX`.`assignations` VALUES (8365, 5948);
INSERT INTO `myX`.`assignations` VALUES (8366, 5948);
INSERT INTO `myX`.`assignations` VALUES (8367, 5948);
INSERT INTO `myX`.`assignations` VALUES (8368, 5948);
INSERT INTO `myX`.`assignations` VALUES (8369, 5948);
INSERT INTO `myX`.`assignations` VALUES (8370, 5948);
INSERT INTO `myX`.`assignations` VALUES (8371, 5948);
INSERT INTO `myX`.`assignations` VALUES (8372, 5948);
INSERT INTO `myX`.`assignations` VALUES (8373, 5948);
INSERT INTO `myX`.`assignations` VALUES (8374, 5948);
INSERT INTO `myX`.`assignations` VALUES (8375, 5948);
INSERT INTO `myX`.`assignations` VALUES (8376, 5948);
INSERT INTO `myX`.`assignations` VALUES (8377, 5948);
INSERT INTO `myX`.`assignations` VALUES (8378, 5948);
INSERT INTO `myX`.`assignations` VALUES (8378, 5896);
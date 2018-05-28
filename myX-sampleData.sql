/* myXData.sql
 * myX sample data
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-21
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
    25,                 /* resultsPerPage */
    1,                  /* listsOrder */
    2                   /* userKind */
);

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


INSERT INTO `myX`.`countries` VALUES (18, "España", 2);
INSERT INTO `myX`.`countries` VALUES (19, "Grecia", 2);
INSERT INTO `myX`.`countries` VALUES (20, "Italia", 2);
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
    "Cartagena: Hotel NH Campo de Cartagena",
    3,
    "Calle Ciudadela, 24, 30203 Cartagena, Murcia",
    18,
    13,
    "hotel de precio asequible situado en un lugar tranquilo",
    "37.612314, -0.976620",
    "37.599019, -0.985648",
    "www.nh-hotels.com/Cartagena/Campo-Cartagena",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    735,
    "",
    "Cartagena: Apartamento de Calíope",
    3,
    "Calle Carlos III, 33, 30201 Cartagena, Murcia",
    19,
    11,
    "",
    "37.605995, -0.983976",
    "37.599019, -0.985648",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    736,
    "",
    "Éfeso: Templo de Artemisa",
    3,
    "",
    18,
    11,
    "El templo de Artemisa en Éfeso era una de las siete maravillas del mundo antiguo",
    "37.949887, 27.363383",
    "",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    737,
    "",
    "Atenas: Partenón",
    3,
    "",
    19,
    11,
    "El Partenón de Atenas era una de las siete maravillas del mundo antiguo",
    "37.971482, 23.726625",
    "",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    738,
    "",
    "Aphrodisias: Templo de Afrodita",
    3,
    "Geyre Mahallesi, Kuyucak Tavas Yolu, 09385 Karacasu/Aydın, Turkey",
    18,
    11,
    "El templo de Afrodita es y sigue siendo el punto principal del sitio, pero el carácter del edificio se alteró cuando se convirtió en una basílica cristiana. Los escultores de Afrodisias eran célebres y se beneficiaron de una gran abundancia de mármol en las montañas cercanas. La escuela de escultura de la ciudad produjo bastantes obras, muchas de las cuales todavía se pueden apreciar en el sitio y en el museo de la ciudad. Durante las excavaciones se encontraron muchas estatuas completas en el área del ágora y estatuas sin terminar en un área que señala el sitio de una escuela de escultura. También se han hallado sarcófagos en varios puntos de la ciudad, la mayor parte de ellos con diseños que constan de guirnaldas y columnas, al igual que pilares con diseños descritos como «manuscritos humanos» o «vivientes», representando personas, pájaros y animales envueltos en hojas de acanto.<br />En el sitio arqueológico alrededor del templo se pueden encontrar rincones ideales para mantener sexo.",
    "37.710071, 28.725108",
    "",
    "www.muze.gov.tr/aphrodisias",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    739,
    "",
    "Sunio: Templo de Poseidón",
    3,
    "Cape Sounio, Sounio 195 00",
    19,
    11,
    "El templo de Poseidón de Sunio era lo primero que veían los navegantes cuando se aproximaban al Ática",
    "37.650153, 24.024572",
    "",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    740,
    "",
    "Monte Cyllene: Templo de Hermes",
    3,
    "",
    19,
    11,
    "El templo de Hermes en el Monte Cyllene se construyó en el lugar en que, según la tradición, nació el dios",
    "37.939785, 22.395832",
    "",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    741,
    "",
    "Argos: Templo de Hera",
    3,
    "",
    19,
    11,
    "El templo de Hera en Argos bla bla bla",
    "37.691998, 22.775001",
    "",
    "" ,
    2
);

INSERT INTO `myX`.`loca` VALUES (
    742,
    "",
    "Roma: Templo de Marte Ultore",
    3,
    "",
    20,
    11,
    "El templo de Marte Ultore en Roma bla bla bla",
    "41.894396, 12.486927",
    "",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    743,
    "",
    "Atenas: Templo de Hefesto (aka Thisio)",
    3,
    "Athens 105 55, Greece",
    19,
    11,
    "El templo de Hefesto en Atenas, erróneamente llamado Thisio, bla bla bla",
    "37.975588, 23.721417",
    "",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    744,
    "",
    "Naxos: Templo de Démeter",
    3,
    "",
    19,
    11,
    "El templo de Démeter en Naxos bla bla bla..",
    "37.029108, 25.431321",
    "",
    "",
    2
);

INSERT INTO `myX`.`loca` VALUES (
    745,
    "",
    "Naxos: Templo de Dionisio",
    3,
    "",
    19,
    11,
    "El templo de Dionisio en Naxos bla bla bla..",
    "37.077697, 25.380779",
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
    "2018-01-01",
    "",
    "Primera experiencia, «ἐν πορνείῳ». Con Actea (Proto?), una hieródula del templo de Afrodita en Corinto, llegó el estreno.<br />aconteció que, tras verla en la estoa del templo y seducido por su buen aspecto no dudé en ir tras ella y abordarle, antes de que alguna otra «rapaz» me quitase la presa. fue fácil; no dudó mucho en venirse conmigo. fuimos al fornix que ella frecuenta, y echamos un polvo «de película». a causa de la calidad del género que tenía entre manos, yo estaba excitadísimo, y ella respondía muy, pero que muy bien. besaba como nadie y también felaba muy bien.<br />lo mejor fue cuando copulamos: ella estaba tumbada boca arriba. se abrió de piernas y sin ningún esfuerzo se lo introduje. una vez con el miembro dentro de su vagina no me importó follarla un poco, aunque sin eyacular dentro. y así lo hice. con lo abierta que estaba, no tuve ninguna dificultad en metérsela hasta los testículos, haciéndole estremecerse de placer.<br />yo daba sacudidas salvajes contra su vagina muriéndome de gusto, y ella disfrutaba «como una perra», aunque la muy «cabrona» ni se tocaba; me tocaba a mí, y a veces me tocaba los testículos y la raíz del miembro para cerciorarse de que lo tenía dentro.<br />me dio mucha pena tener que sacarla cuando estaba cerca de eyacular. me masturbé salvajemente, hasta «descargar» envuelto en un inmenso placer. ella tardó bastante tiempo más en llegar al orgasmo. al principio le estimulaba yo el clítoris, y al ver que no se acababa nunca le dije que lo hiciese ella misma, y mientras tanto yo le besaba, le acariciaba los pechos y le introducía un dedo por el ano. al final llegó al orgasmo entre espasmos de placer.",
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
    "2018-01-02",
    "",
    "esta es la experiencia número dos, experiencia vivida con XXX.<br />el sexo fué de lo más gratificante. cómodos y límpios, en una cama grande, me trató con delicadeza y dulzura. nos besamos, nos acariciamos tiérnamente. todo fué muy tierno aunque eso no quitó de disfrutar de lo más duro y placentero del sexo.<br />me propuso que la penetrase, y yo acepté nervioso. me puse timidamente el preservativo y, afortunadamente, debido a su experiencia, todo fué «sobre ruedas». se la metí de golpe, y ella se estremeció de placer. fué superexcitante.<br />no eyaculé dentro -eso hubiera sido perfecto-, pero disfrute como nunca lo habría imaginado.<br />cuando se fué me quedé completamente colado por ella.",
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
    "2018-01-03",
    "",
    "trío con XXX1 y XXX2. fue fantástico: me lo ligué con la mirada en ... . XXX1 no estaba muy convencido de ella, aunque a mí me gustaba bastante. «llevárnosla» fue muy fácil, pues en la puerta de ... le propusimos venirse con nosotros, y ella aceptó sin pensárselo.<br />fuimos con el coche a una calle sin salida, justo detrás de... . paré con el coche mirando hacia la salida, y puse el quitasol en el parabrisas. acto seguido nos pasamos a la parte de atrás, dejando a la chica en medio; me quité las botas, y no perdimos el tiempo:<br />comenzamos a besuquearnos y a acariciarnos a tres bandas, la chica respondía muy bien; nosotros dos también. nos fuimos desnudando gradualmente, y así pudimos contemplar su cuerpo en línea y su ... . una vez desnudos vimos que la chiquilla no se andaba con remilgos: a mí me felaba el miembro, mientras le daba el culo a XXX1. primero me la chupó a mí. después se dio la vuelta y ... a XXX1, y XXX1 le hizo un cunnilingus. siguió XXX2 chupando a XXX1...<br />entonces yo aproveché para ir trabajándole el clítoris. cuando pasó un rato XXX1 me vio las intenciones y le dijo: «<cite>¿Quieres que mi novio te meta la punta?</cite>», a lo que ella respondió: «<cite>Sin condón, no</cite>». entonces le dijimos: «<cite>Tenemos condones de sobra</cite>», mientras yo ya estaba cogiendo uno de mi pantalón.<br />me lo puse en el miembro, y empecé con las maniobras de penetración, aunque enseguida me di cuenta de que no iba a ser demasiado fácil. entonces me escurrí por debajo suya y empecé a lamer su culete, lo que parece que le dio mucho gusto a juzgar por los gemidos que daba. yo pensaba: «<cite>¡Cuando te meta el miembro te va a gustar todavía más!</cite>» enseguida me incorporé y retomé las maniobras, justo donde las había dejado, alcanzando con éxito la penetración anal completa en pocos segundos.<br />su cuerpo empezó a destensarse, y comenzamos a gozar. le fui dando sacudidas profundas, pero no muy fuertes, pues lo que yo quería era preparar esa conducto estrecho para que todos sintiéramos placer. la chavala emitía unos sonidos lastimeros, mezcla de placer y, al principio, de dolor; pero todo el dolor se transformó rápidamente en placer, y mi miembro entraba y salía de su culete con facilidad. XXX2 daba entonces profundos suspiros, envuelta en placer. XXX1 se masturbaba mientras la acariciaba y, a veces, ... .<br />... al tener la boca libre nos hizo notar aún más lo bien que lo estaba pasando, pues sus gemidos y suspiros eran continuos...",
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
    "2018-01-04",
    "",
    "no tuve que trabajar mucho para beneficiármela, fue un regalo del cielo. al contrario, me pilló casi por sorpresa. a ella le bastó echar un ojo al interior de mi fornix, donde estaba yo tendido desnudo, para quedarse atento a mi reacción, la cual no se hizo de esperar.<br />entró inmediatamente, y yo empecé a comerle los pezones y a deleitarme del tamaño y la dureza de su pecho. simultáneamente, comencé a explorar lo que había mas abajo de la cintura, bajo la toalla, y descubrí con mucho gusto ...<br />πὼ πώ, ¡Dios qué tiaza! me la comí viva por todas partes, intentando disfrutar lo más posible de esos momentos que normalmente no se presentan cada día. ella se mostró más fría, y no sólo no me comió en el cuerpo, sino que evitó incluso el besarme; eso no quita que disfrutase también ella como un enano de mi cuerpo serrano.<br />al poco rato de «marraneo» me di cuenta de que se dejaba trabajar el culo más de lo normal. por supuesto ella ya había reparado en el tamaño y la dureza de mi miembro, y me hizo ver claramente que quería que le metiese «caña de España». se me dio la vuelta, me puso su culo en pompa y me largó un condón (que había traído consigo).<br />se la clavé profundamente. me la follé durante un buen rato, y mientras la follaba recorría con mis manos y mi boca su cuerpo de Venus. ella se sometía sumisamente a los viajes de mi pene erecto, y comprobaba de cuando en cuando la placentera presencia de mi miembro en su ojete. cambiamos dos veces de postura, y acabamos finalmente la cópula estando ella tumbada boca arriba, lo cual me dio la oportunidad de disfrutar plenamente de la contemplación de su cuerpazo mientras la follaba, y aún deleitarme de la caricia fogaz de su pecho terso.<br />en estas condiciones hubiera sido difícil no eyacular, lo cual hice encantado haciéndole ver abiertamente de qué modo gozaba. al momento me estaba haciendo un gesto de dolor para que se la sacara del culo, tan fría como ella misma lo había sido durante todo el rato.<br />fue apoteósico. magnífico. maravilloso. un polvo para no olvidar.<br />ella se comportó como una «cabrona» folladora, tan fría, tan bien equipada, tan sumisa... yo me comporté como un «cabrón» follador, tan sintabúes, tan dominante, tan «<i>yo me corro; tú haz lo que quieras</i>». comprensión total. disfrute pleno.<br />me pedía después del polvo que encendiese la luz: «<cite>Es ist ein Bisschen dunkel hier, oder?</cite>» quería ver con detalle al toro que se la había follado. la impresión debió resultar -espero- positiva. sin embargo, para no variar, siguió comportándose tan fríamente como lo había hecho todo el rato, y se largó al momento con un simple «<i>Tschüß</i>».<br />no importa. el disfrute que tuve con la cópula me había dejado totalmente satisfecho... y casi exhausto.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8283,
    "",
    "coito activo en trío con eyaculación",
    3,
    0,
    735,
    "2018-01-05",
    "",
    "se lo estaban montando con mucha calma a la espera de un tercer vértice para el triángulo. entonces aparecí yo.<br />después de un rato no corto de «marraneo» inicial copulé con ambas; empecé por la que parecía más joven, y durante un rato bastante grande le penetré con fuerza y ganas.<br />después la otra, envidiosa, le dijo que ella también quería, por lo que cambiaron, y me follé a la otra con la fuerza de un toro salvaje. la «cabrona» disfrutó como una «puta perra», y los gritos que daban no parecían ser humanos.<br />después del polvo (ambas se corrieron, yo no), «flipaban» entre ellas de ver cómo me las había follado. me miraban y sonreían. yo estaba bañado en sudor.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8284,
    "",
    "coito activo con eyaculación",
    3,
    0,
    735,
    "2018-01-06",
    "",
    "la segunda vez con ella -por cierto, ella no me reconoció-, no hizo falta demasiado flirteo para comprender nuestras intenciones: nos deseábamos.<br />entré en ... ; me siguió; nos enrollamos de inmediato. con mucho frenesí nos comimos la boca, nos estrujamos, «nos dimos caña». la manoseé viva, y ella hizo lo mismo conmigo. me feló el miembro (en bastantes ocasiones) haciéndome un «<i>deep-throat</i>» tan regular y bien hecho que llegó a asombrarme. le trabajé el clítoris a base de bien. πὼ πώ, ¡qué bueno!<br />después de un rato de trajineo en ese «agujero del placer» me la follé viva un montón de ocasiones, utilizando para ello nada menos que cuatro condones diferentes. y entre clavada y clavada «marraneábamos», nos comíamos las bocas.<br />asumo que acabé eyaculando.",
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
    736,
    "2018-01-07",
    "",
    "nos enrollamos en un rincón oscuro; luego fuimos a un fornix.<br />se puso hecha una «zorra», me manoseó y me comió vivo. se mediodesnudó, se arrodilló ante mí, y me la comió enteretita.<br />mientras, yo ya le había estado palpando el ano: follastible. seguí durante un rato «trabajándole» el culete; ella con la <i>fellatio</i>. así que, al poco rato, se ofreció a ser follada. ante mi respuesta afirmativa, se terminó de desnudar, se colocó en el <i>sling</i>, se abrió de piernas.<br />le clavé la punta de mi miembro en su ano abierto y, en lugar de follarlo, hice balancear muy despacito el <i>sling</i> de modo que mi pene le entraba y salía muy, muy despacio, disfrutando al máximo su culete en cada milímetro de mi miembro tieso. πὼ πώ, ¡fué totalmente «<i>geil</i>»! entonces le pregunté si le gustaba más de esa manera o de... «<cite>¡Ésta!</cite>», dije, mientras se la clavava con la fuerza de un toro salvaje. le encantó, a la «zorra». me dijo que era un buen follador. le estuve metiendo embestidas un buen rato...<br />me había pedido que eyaculase en sus pechos, y había llegado el momento. se la saqué, rodeé el <i>sling</i> y se la metí en la boca, que la tenía abierta con la cabeza girada hacia atrás. <i>deep throat</i>. tanto, que hasta me dolía.<br />al ratito se la saqué y, masturbándome frenéticamente, eyaculé descargando toda mi virilidad en su barbilla, cuello y pechos. entonces llegó ella al orgasmo, masturbándose.<br />le encantó, a la «perra». se quedó flipando. no paró de elogiarme.<br /><i>intermission...</i>",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8286,
    "",
    "Juego carnal con eyaculación",
    3,
    0,
    737,
    "2018-03-26",
    "",
    "Lorem ipsum",
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
    "2018-04-03",
    "",
    "nada más acercame a ella en la puerta del local se abalanzó sobre mí como un loco, con una pasión desenfrenada. nos comimos vivos, me la estuvo chupando un buen rato, y disfrutamos bastante de nuestros cuerpos.<br />cuando me decidí a «trajinarle» el culete, casi al momento me di cuenta de que la «cabrona» estaba más que abierta. entonces, viendo ella la dureza de mi miembro, se me puso «superperra», se dio la vuelta y quiso que se la clavase así, sin más, y allí mismo. tuve que pararla para colocar profilaxis, pero al momento se la estaba clavando en el culete con toda la facilidad del mundo mientras ella, doblada como una bisagra, disfrutaba de mi polla dura.<br />me la follé viva. incluso esnifé <i>poppers</i> de mi primera flamante botella que había comprado. ella me agarraba frenéticamente y me empujaba hacia sí, para clavársela más profundamente.<br />durante un buen rato estuvimos follando. revoloteaban «moscones» que teníamos que apartar. a mí se me bajó un poco la dureza. decidí sacársela y, mientras me masturbaba, seguí «trabajándole» el ano con un dedo. se me volvió a poner superdura, y pensé en volver a clavársela. pero en estas la «cabrona» se corrió, y ahí quedó la cosa.",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8288,
    "",
    "coito activo en trío con eyaculación",
    3,
    0,
    739,
    "2018-03-25",
    "",
    "sin grandes preámbulos nos enrollamos con la chica sin inhibiciones, y nos chupamos y «marraneamos» bastante.<br />cuando observamos la apertura de su esfinter anal, y comprendimos que estaba pidiendo «pija» a gritos, nos retiramos a un lugar más apartado, e íntimamente, sin interrupciones por fortuna, nos la follamos repetidas veces, y alternadamente, Mario y yo, todo entre fellatio y cunnilingus.<br />en una de estas Mario se corrió en su culito. yo prohibí a XXX que se corriera, con el deseo <i>expresis verbis</i> de follarle también yo, e inundar su culo de leche.<br />dicho y hecho: relevé a Mario, que exhausto se retiraba a observar, y arremetí contra la abierta vagina de XXX, a la cual propicié varios viajes que nos hacían corrernos placenteramente al unísono.",
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
    "2018-03-23",
    "",
    "Lorem ipsum",
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
    740,
    "2018-03-19",
    "",
    "como tenía ganas de «beneficiármela» (más que nada para satisfacer mi curiosidad), esa noche me la trabajé un poco -no demasiado-, y me la llevé a la cama.<br />después de los preámbulos (¡una forma ridícula de besar!), que con el «derroche» de <i>sex-appeal</i> suyo no se realizaron demasiado satisfactoriamente, me la manejé hasta ponérmelo «a tiro», y me la «trinqué» por detrás. a pesar de las lógicas dificultades iniciales, con la ayuda de crema lubricante al poco ratito entraba con facilidad. intenté follármela salvajemente para dejarla satisfecho, que no quedase decepcionada del «producto nacional».<br />y aunque un ratito muy satisfactoriamente la porculeé, al rato me di cuenta de que no la tenía todo lo dura que debiese, con lo que decidí acabar con la porculada (recuerdo a la pobre con el culo «en pompa» y, esperando una nueva embestida, darse cuenta que la «inyección» había acabado).<br />se supone que el polvo acabó en corrida.",
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
    741,
    "2018-03-16",
    "",
    "fue muy, muy «puta»: nada más percatarse que iba a por ella, al entrar yo en la cabina, sin mediar palabra ni gestos, comenzó a desnudarse. se quitó todo lo de abajo, dejándose la camiseta, y a continuación se tumbó en el <i>sling</i>. yo había aprovechado para manosearla mientras se desnudaba, pero ella no quería «marraneo», sino sólo follada.<br />así que, tumbado de patas abiertas, esnifó <i>poppers</i> y me dijo: «<cite>¡Fóllame!</cite>». aproveche para tomar de su <i>poppers</i>, me puse caliente, y la penetré sin dificultad alguna. aproveché para «manosear» lo que pude su cuerpo, y le estrujé sus pechos. πὼ πώ, ¡estaba buena, la «cabrona»!<br />le gustó, a la «perra». al cabo de un rato me dijo que no podía mas, así que se la saqué y le hice que me la felase durante un buen rato. me dijo que podía eyacular en su boca; estaba deseando que lo hiciera. me masturbaba frenéticamente la raíz del miembro mientras que con la lengua fuera de la boca chupaba el glande.<br />me puse muy caliente. tanto, que sentí la necesidad de volver a «clavársela»… lo cual hice, proporcionándole a ella y a mí mismo nuevos placeres «chechuales». más cópula, más pellizcos en los pezones, más «trajineo» de los pechos...<br />me incitó nuevamente a que me corriese, lo cual *NO* deseaba hacer.<br />al final, habiendo visto ella que yo no estaba dispuesto a acabar, me dijo que de verdad no podía mas, por lo que lo acabamos dejando.<br /><i>intermission...</i>",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8292,
    "",
    "coito activo con eyaculación",
    3,
    0,
    742,
    "2018-03-12",
    "",
    "la conquisté con la táctica de la hormiga león, y al momento le estaba dando «caña de España».<br />casi inmediatamente empecé a trabajarle el chochete, cerciorándome de que lo tenía accesible. le di entonces la vuelta, la doblé y se la clavé sin apenas dificultades. le trajiné el culete bastante bien, y mis salvajes sacudidas debieron de gustarle.<br />a mí me dio tanto placer ese «ojete de XXX», que al poco rato me estaba corriendo en mis últimos «viajes». una vez hube acabado y se la hube sacado del culo se largó, satisfecha, sin mediar palabra.<br /><i>intermission...</i>",
    4,
    1,
    2
);

INSERT INTO `myX`.`practica` VALUES (
    8293,
    "",
    "coito activo con eyaculación",
    3,
    0,
    743,
    "2018-03-07",
    "",
    "después del «marraneo» inicial, y viendo que se dejaba «trajinar» bien, me la follé con relativa facilidad. se puso muy «puta»; se doblaba cual bisagra, y se abría los labios vaginales para que le entrase más adentro. yo no quería correrme todavía, por lo cual al ratito se la saqué.<br />sin embargo la «cabrona» consiguió mantenerme caliente con sus calientes felaciones, y al rato se la estaba metiendo de nuevo en las mismas condiciones de antes. pasado un rato decidí dejarlo estar.<br />ella, sin embargo, no se resistía a acabar con el asunto, así que me la chupaba una y otra vez. comprendí sus intenciones inmediatamente. le agarré la cabeza y le follé la boca durante un ratito, hasta que eyaculé dentro.<br />la «cabrona», en cambio, no se corrió. fue más lista que yo.",
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
    "Calíope María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "caliope@gmail.com",
    "fecha de nacimiento: 1973-01-01",
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
    "Skype: clio1973; Badoo: clio1973; Instagram: clio1973",
    "Clío María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "clio@gmail.com",
    "fecha de nacimiento: 1973-01-01",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5871,
    "",
    "Erato",
    3,
    2,
    "chica francesa de 19 años, no demasiado agraciada de cara",
    "cuerpecillo esbelto con cinturita de avispa y piernas delgadas",
    "pechos pequeños con prominentes pezones, lleva el vello púbico graciosamente recortado",
    "muy morbosa y muy mandona",
    "Skype: erato1973; Badoo: erato1973; Instagram: erato1973",
    "Érato María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "erato@gmail.com",
    "fecha de nacimiento: 1973-01-01",
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
    "Skype: euterpe1973; Badoo: euterpe1973; Instagram: euterpe1973",
    "Euterpe María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "euterpe@gmail.com",
    "fecha de nacimiento: 1973-01-01",
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
    "Melpómene María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "melpomene@gmail.com",
    "fecha de nacimiento: 1973-01-01",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5874,
    "",
    "Polimnia",
    2,
    2,
    "mujer española de 30 años, de apariencia normal aun no siendo muy agraciada de cara",
    "de complexión gruesa, cuerpo algo rollizo",
    "pechos de tamaño mediano-grande, quizá no tan grandes como cabría esperar",
    "bastante viciosilla",
    "Skype: polimnia1973; Badoo: polimnia1973; Instagram: polimnia1973",
    "Polimnia María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "polimnia@gmail.com",
    "fecha de nacimiento: 1973-01-01",
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
    "Talía María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "talia@gmail.com",
    "fecha de nacimiento: 1973-01-01",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5876,
    "",
    "Terpsícore",
    3,
    2,
    "mujer española de 29 años, de buena apariencia aun no siendo demasiado guapa",
    "cuerpo regularcillo, algo fofo",
    "impresionantes pechos, si bien no muy firmes",
    "algo modosita y muy púdica en el sexo",
    "Skype: terpsicore1973; Badoo: terpsicore1973; Instagram: terpsicore1973",
    "Terpsícore María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "terpsicore@gmail.com",
    "fecha de nacimiento: 1973-01-01",
    2
);

INSERT INTO `myX`.`amores` VALUES (
    5877,
    "",
    "Urania",
    4,
    2,
    "chica española (19 años), de muy buen ver y muy guapa",
    "buen cuerpo, delgadito y fibrado",
    "pechos algo pequeños, muy firmes",
    "muy viciosilla para lo joven que es",
    "Skype: urania1973; Badoo: urania1973; Instagram: urania1973",
    "Urania María Pérez Pérez",
    0,
    "(+34) 661 662 663",
    "urania@gmail.com",
    "fecha de nacimiento: 1973-01-01",
    2
);

/*
 * sample data for tabla 'assignations'.
 * experiences: 8279 .. 8293.
 * lovers: 5869 .. 5877.
 */

INSERT INTO `myX`.`assignations` VALUES (8279, 5869);
INSERT INTO `myX`.`assignations` VALUES (8280, 5869);
INSERT INTO `myX`.`assignations` VALUES (8281, 5869); /* trio 1/2 */
INSERT INTO `myX`.`assignations` VALUES (8281, 5870);
INSERT INTO `myX`.`assignations` VALUES (8282, 5869); /* trio 2/2 */
INSERT INTO `myX`.`assignations` VALUES (8282, 5870);
INSERT INTO `myX`.`assignations` VALUES (8283, 5870);
INSERT INTO `myX`.`assignations` VALUES (8284, 5871);
INSERT INTO `myX`.`assignations` VALUES (8285, 5872);
INSERT INTO `myX`.`assignations` VALUES (8286, 5873);
INSERT INTO `myX`.`assignations` VALUES (8287, 5874);
INSERT INTO `myX`.`assignations` VALUES (8288, 5874);
INSERT INTO `myX`.`assignations` VALUES (8289, 5874);
INSERT INTO `myX`.`assignations` VALUES (8290, 5875);
INSERT INTO `myX`.`assignations` VALUES (8291, 5876);
INSERT INTO `myX`.`assignations` VALUES (8292, 5877);
INSERT INTO `myX`.`assignations` VALUES (8293, 5877);

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

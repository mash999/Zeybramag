-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2018 at 01:43 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magazine`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `TABLE_ID` int(11) NOT NULL,
  `ARTICLE_ID` varchar(130) NOT NULL,
  `ARTICLE_LOCATION` text,
  `ARTICLE_TAGS` varchar(300) DEFAULT NULL,
  `ARTICLE_MEDIA` text,
  `POSTED_BY` varchar(120) NOT NULL,
  `ARTICLE_STATUS` int(11) NOT NULL,
  `APPROVED_BY` int(11) NOT NULL,
  `PUBLISHER_TYPE` varchar(15) NOT NULL,
  `TILE_TYPE` varchar(30) NOT NULL,
  `PUBLISH_TIME` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`TABLE_ID`, `ARTICLE_ID`, `ARTICLE_LOCATION`, `ARTICLE_TAGS`, `ARTICLE_MEDIA`, `POSTED_BY`, `ARTICLE_STATUS`, `APPROVED_BY`, `PUBLISHER_TYPE`, `TILE_TYPE`, `PUBLISH_TIME`) VALUES
(1, '200520181526808344DHABAN', 'Warsh, Poland', '', '5b014d253b3d11.jpg', '1', 1, 1, 'contributor', 'article-type-1', 1526811941),
(2, '200520181526809034DHABAN', 'Portugal', '', '', '1', 1, 1, 'contributor', 'article-type-4', 1526811958),
(3, '200520181526809243DHABAN', 'Germany', '', 'https://www.youtube.com/watch?v=v7H_Or9Nr5I', '1', 1, 1, 'contributor', 'article-type-2', 1526853491),
(4, '200520181526810626AMSNET', 'Bangladesh', '', '5b014d0e6f79e5acb42b935ed95aa03e9450fa1qualifications.JPG', '1', 1, 1, 'editor', 'article-type-3', 1526811918),
(5, '210520181526905557AMSNET', 'joypurhat', '', '', '1', -1, 1, 'editor', 'article-type-4', 1526905594);

-- --------------------------------------------------------

--
-- Table structure for table `article_translations`
--

CREATE TABLE `article_translations` (
  `TABLE_ID` int(11) NOT NULL,
  `ARTICLE_ID` varchar(130) NOT NULL,
  `ARTICLE_LANGUAGE` varchar(60) NOT NULL,
  `ARTICLE_TITLE` text NOT NULL,
  `ARTICLE_HASHTAGS` varchar(500) DEFAULT NULL,
  `ARTICLE_BODY` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article_translations`
--

INSERT INTO `article_translations` (`TABLE_ID`, `ARTICLE_ID`, `ARTICLE_LANGUAGE`, `ARTICLE_TITLE`, `ARTICLE_HASHTAGS`, `ARTICLE_BODY`) VALUES
(1, '200520181526808344DHABAN', 'us', 'Success. Let\'s take a moment to breathe.', 'jqweqe,qwe121,vxcv,dada', 'Success. Let\'s take a moment to dive into this rather elusive word, metaphor or tagline. It\'s all the rage these days, but what does it truly mean and why is it so elusive? &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nWhen we look at the etymology of the word, earliest records date back to the 1530s. Then itâ€™s no surprise to hear it comes from Latin â€˜successusâ€™. The meaning back then meant a whole lot less than today, or did it? Success in today\'s world is sometimes seen as an end goal. He or she has \'\'made it\'\' but success is a constant, evolving state of mind. As our personalities change throughout the years, being influenced by place, people and all the rest, success changes with us. That\'s why success seems so hard for us to attain at times, because actually we don\'t know what success is or what we\'re looking for in the first place. When does the world turn around and say. Yes you have now been granted the title of \'\'successful\'\'? &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nSuccess is a personal journey, but hidden beneath all that success is a drive to be accepted and respected by the world around you. What if we live in an infinite player world where you can never \'\'win\'\' the respect of your peers? If there are infinite players, how can you ever win? Maybe we\'re chasing the dragon. The first step toward real success is to accept yourself, enjoy the journey you have chosen through life and be grateful for the small things that life has brought you to date. Success will then become less of an elusive point on the horizon but will become a driving force behind you with a tank full of gratitude to keep pushing you forward toward more rewarding experiences and moments in the future (that you can be grateful for). This is more of supportive push up the hill, in place of a dangling bottle of whiskey in front when youâ€™re stuck in a wheelchair. :)&lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\n The secret to success is quite simple. Don\'t chase it. Be happy for the world you live in, the job that chose you, the friends that made you and the opportunities will present themselves on your journey. Remember it\'s your journey, there\'s no prize for best dressed. You\'re the only player in this game, so you\'re already a winner by default. How does that feel? Keep your eyes open, anticipate more great things and they\'ll start to come your way. Everything in nature follows the same principles, take for example the water cycle; Water evaporates into clouds, later bursts onto the mountains as rain, only to trickle down the mountain back to the ocean. Does the ocean chase after it\'s prized possession or does it simply expect a return in abundance? I\'ll leave that one there for the philosophers to chew on. The point here is to move into a natural cycle by deciding on a purpose, taking action and letting nature take its course by giving, receiving and constantly evolving you work with nature instilling a \'\'success\'\' mindset that will happily drive you through the ups, downs and give you a tingle of excitement and pride when you look back and think. \'\'We made it baby\'\'&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nI hope and expect this little piece has been inspiring. I\'d be delighted it if you shared it and if you have any topics you\'d like me to write about just pop me a mail and I\'ll get right to it.'),
(2, '200520181526808344DHABAN', 'pl', 'Sukces. Zatrzymajmy siÄ™ na chwilÄ™ aby zagÅ‚Ä™biÄ‡ ', '', 'Sukces. Zatrzymajmy siÄ™ na chwilÄ™ aby zagÅ‚Ä™biÄ‡ siÄ™ w to doÅ›Ä‡ trudne do okreÅ›lenia sÅ‚owo, czy teÅ¼ metaforÄ™ lub slogan. Bardzo popularne ostatnio ale co tak naprawdÄ™ oznacza i czemu jest aÅ¼ tak  trudne do zdefiniowania?&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nKiedy spojrzymy na etymologiÄ™ tego sÅ‚owa okaÅ¼e siÄ™, Å¼e sukces wywodzi siÄ™ od Å‚aciÅ„skiego successus, o czym Å›wiadczÄ… zapisy juÅ¼ z 1530 roku. Ale czy znaczenie tego sÅ‚owa byÅ‚o na tyle wielkie juÅ¼ wtedy? Sukces w dzisiejszym Å›wiecie jest widziany jako gol ostateczny, ostateczne speÅ‚nienie.&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nMoÅ¼na myÅ›leÄ‡ &quot;dokonaÅ‚em/am tego&quot;, ale sukces to przecieÅ¼ nieustanny rozwÃ³j umysÅ‚u. Podczas gdy Twoja osobowoÅ›Ä‡ zmienia siÄ™ w ciÄ…gu Å¼ycia, pod wpÅ‚ywem miejsc, ludzi i wszystkiego co nas otacza, sukces zmienia siÄ™ wraz z nami. Dlatego teÅ¼ czasem wydaje siÄ™ tak trudny do osiÄ…gniÄ™cia, gdy tak naprawdÄ™ nie potrafimy okreÅ›liÄ‡ czym jest i czego w gruncie rzeczy oczekujemy.&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nBo kiedy wÅ‚aÅ›ciwie Åšwiat siÄ™ dla nas na chwilÄ™ zatrzyma aby powiedzieÄ‡: &quot;jesteÅ› teraz oficjalnie czÅ‚owiekiem sukcesu&quot;? Sukces jest osobistÄ… podrÃ³Å¼Ä…, ktÃ³ra ukrywa jednÄ… prawdÄ™- poÅ¼Ä…dajÄ…c sukcesu szukamy akceptacji i szacunku ze strony otaczajÄ…cego nas Å›wiata. A co jeÅ›li to jest gra z nieskoÅ„czonÄ… iloÅ›ciÄ… graczy? Jak w takiej sytuacji moÅ¼na kiedykolwiek wygraÄ‡? ByÄ‡ moÅ¼e to jest tylko pogoÅ„ za wiatrem.&lt;/p&gt;&lt;p&gt;\r\nPierwszym krokiem do sukcesu jest samoakceptacja, radoÅ›Ä‡ z drogi, ktÃ³rÄ… siÄ™ obraÅ‚o i wdziÄ™cznoÅ›Ä‡ za wszystko co nam los daÅ‚. Wtedy sukces nie bÄ™dzie juÅ¼ tylko tym nieokreÅ›lonym punktem gdzieÅ› na horyzoncie ale siÅ‚Ä… napÄ™dowÄ…, ktÃ³ra pcha nas do nowych doÅ›wiadczeÅ„ i chwil, za ktÃ³re moÅ¼emy byÄ‡ wdziÄ™czni. Bardziej jako to lekkie pchniÄ™cie w drodze pod gÃ³rÄ™, zamiast przysÅ‚owiowego kija i marchewki.&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nSekret sukcesu jest doÅ›Ä‡ prosty.&lt;/p&gt;&lt;p&gt;\r\nNie goÅ„ go.&lt;/p&gt;&lt;p&gt;\r\nDoceÅ„ Å›wiat, w ktÃ³rym Å¼yjesz. DoceÅ„ pracÄ™, ktÃ³ra Ciebie wybraÅ‚a, przyjaciÃ³Å‚, ktÃ³rzy uczynili CiÄ™ tym kim teraz jesteÅ› a okazje same pojawiÄ… siÄ™ na Twojej Å›cieÅ¼ce. PamiÄ™taj, Å¼e to Twoja wÅ‚asna droga, tu nie ma nagrody za najlepszy kostium. JesteÅ› jedynym graczem w tej grze, wiÄ™c z gÃ³ry wygrywasz. Jak siÄ™ z tym czujesz? Trzymaj oczy otwarte, oczekuj wielkich rzeczy a one same siÄ™ pojawiÄ…. Wszystko w naturze podporzÄ…dkowane jest tym samym prawom, weÅºmy na przykÅ‚ad cykl wodny: woda paruje tworzÄ…c chmury aby pÃ³Åºniej spaÅ›Ä‡ deszczem na szczyty gÃ³rskie i nastÄ™pnie spÅ‚ynÄ…Ä‡ strumieniem do oceanu. Czy ocean goni za tÄ… wodÄ… czy najzwyczajniej oczekuje jej powrotu, jako prawowity wÅ‚aÅ›ciciel? To jednak zostawmy filozofom do rozgryzienia. Chodzi o to, aby wÅ‚Ä…czyÄ‡ siÄ™ w ten naturalny cykl poprzez obranie celu i ruszenie do akcji a natura sama zadba o resztÄ™- poprzez dawanie, przyjmowanie i ciÄ…gÅ‚y rozwÃ³j wÅ‚Ä…czasz siÄ™ w ten naturalny cykl natury. W ten sposÃ³b zagnieÅ¼dÅ¼asz ten swoisty &quot;mindset sukcesu&quot;, ktÃ³ry pomoÅ¼e Ci przebrnÄ…Ä‡ przez wszystkie wzloty i upadki  i da Ci dreszczyk emocji oraz poczucie dumy gdy spojrzysz w tyÅ‚ i pomyÅ›lisz- We made it baby!&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nMam nadziejÄ™, Å¼e ten krÃ³tki wpis CiÄ™ zainspirowaÅ‚. BÄ™dÄ™ wdziÄ™czny, jeÅ›li podzielisz siÄ™ nim ze znajomymi! JeÅ›li masz jakieÅ› pomysÅ‚y na kolejny artykuÅ‚, daj znaÄ‡ mailem a ja zajmÄ™ siÄ™ resztÄ…!&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nNa zdrowie!'),
(3, '200520181526809034DHABAN', 'us', 'Success. Let\'s take a moment to breathe.', 'ieoq,qweqeq,fsfs,afsfas', 'Success. Let\'s take a moment to dive into this rather elusive word, metaphor or tagline. It\'s all the rage these days, but what does it truly mean and why is it so elusive? &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nWhen we look at the etymology of the word, earliest records date back to the 1530s. Then itâ€™s no surprise to hear it comes from Latin â€˜successusâ€™. The meaning back then meant a whole lot less than today, or did it? Success in today\'s world is sometimes seen as an end goal. He or she has \'\'made it\'\' but success is a constant, evolving state of mind. As our personalities change throughout the years, being influenced by place, people and all the rest, success changes with us. That\'s why success seems so hard for us to attain at times, because actually we don\'t know what success is or what we\'re looking for in the first place. When does the world turn around and say. Yes you have now been granted the title of \'\'successful\'\'? &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nSuccess is a personal journey, but hidden beneath all that success is a drive to be accepted and respected by the world around you. What if we live in an infinite player world where you can never \'\'win\'\' the respect of your peers? If there are infinite players, how can you ever win? Maybe we\'re chasing the dragon. The first step toward real success is to accept yourself, enjoy the journey you have chosen through life and be grateful for the small things that life has brought you to date. Success will then become less of an elusive point on the horizon but will become a driving force behind you with a tank full of gratitude to keep pushing you forward toward more rewarding experiences and moments in the future (that you can be grateful for). This is more of supportive push up the hill, in place of a dangling bottle of whiskey in front when youâ€™re stuck in a wheelchair. :)&lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\n The secret to success is quite simple. Don\'t chase it. Be happy for the world you live in, the job that chose you, the friends that made you and the opportunities will present themselves on your journey. Remember it\'s your journey, there\'s no prize for best dressed. You\'re the only player in this game, so you\'re already a winner by default. How does that feel? Keep your eyes open, anticipate more great things and they\'ll start to come your way. Everything in nature follows the same principles, take for example the water cycle; Water evaporates into clouds, later bursts onto the mountains as rain, only to trickle down the mountain back to the ocean. Does the ocean chase after it\'s prized possession or does it simply expect a return in abundance? I\'ll leave that one there for the philosophers to chew on. The point here is to move into a natural cycle by deciding on a purpose, taking action and letting nature take its course by giving, receiving and constantly evolving you work with nature instilling a \'\'success\'\' mindset that will happily drive you through the ups, downs and give you a tingle of excitement and pride when you look back and think. \'\'We made it baby\'\'. &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nI hope and expect this little piece has been inspiring. I\'d be delighted it if you shared it and if you have any topics you\'d like me to write about just pop me a mail and I\'ll get right to it.&lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nSlÃ¡inte&lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nColin'),
(4, '200520181526809034DHABAN', 'pt', 'Sucesso. Vamos tirar um momento', '', 'Sucesso. Vamos tirar um momento para mergulhar nas Ã¡guas desta palavra ou metÃ¡fora que Ã© tÃ£o elusiva. Ela estÃ¡ em todos os lugares nos dias de hoje, mas o que ela realmente significa e por que Ã© tÃ£o elusiva, tÃ£o obscura?&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nQuando olhamos Ã  origem da palavra, seus primeiros registros datam de 1530, derivada do Latin Successus. Mas seu sentido naquela Ã©poca significava algo bem diferente do que nos dias de hoje, ou serÃ¡ que nÃ£o? Sucesso, nos dias de hoje, Ã© visto muitas vezes como o Ãºltimo obstÃ¡culo a ser cumprido. Talvez ele ou ela tenham vencido este Ãºltimo desafio, mas o sucesso continuarÃ¡ sendo uma constante mudanÃ§a de um estado de espÃ­rito. Ao passo que nossa personalidade muda com o decorrer do tempo, ao sermos influenciados por lugares, pessoas, e todo o resto, nossa definiÃ§Ã£o de sucesso muda tambÃ©m. Ã‰ por este motivo que sucesso parece ser tÃ£o difÃ­cil de ser alcanÃ§ado em alguns momentos porque, em primeiro lugar, nÃ£o sabemos o que ele significa ou pelo que estamos procurando. Quando Ã© que esta palavra nos aborda e nos contempla com o tÃ­tulo de â€œPessoa de Sucessoâ€?&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nO Sucesso Ã© uma jornada pessoal, mas por debaixo disso hÃ¡ ainda uma sÃ©rie de fatores a serem aceitados e respeitados pelo mundo ao seu redor. E se vivemos em um jogo infinito onde nunca podemos â€œvencerâ€ o respeito dos outros jogadores? Se existem infinitos jogadores, como Ã© que eu poderia vencer? Talvez estejamos tentando capturar um dragÃ£o. O primeiro passo rumo ao verdadeiro sucesso Ã© aceitar a sÃ­ mesmo, aproveitar a jornada que escolhemos nesta vida e sermos gratos pelas pequenas coisas que a vida nos trouxe atÃ© entÃ£o. Desta forma, o sucesso deixarÃ¡ de ser o pote de ouro no final do arco-iris e passarÃ¡ a ser o impulso que te levarÃ¡ em direÃ§Ã£o a experiÃªncias mais gratificantes e momentos no futuro (pelos quais vocÃª poderÃ¡ ser grato). Mais como um empurrÃ£o ao subir uma montanha do que sentir pena de sÃ­ mesmo por nÃ£o conseguir escalÃ¡-la sozinho.&lt;/p&gt;&lt;p&gt;\r\nO segredo do sucesso Ã© bem simples: nÃ£o o persiga. Seja feliz pelo mundo no qual vocÃª vive, pelo trabalho que o escolheu, os amigos que vocÃª tem e as oportunidades se apresentarÃ£o para vocÃª em sua jornada. Lembre-se: Ã© a sua jornada, nÃ£o hÃ¡ prÃªmio  para o mais bem vestido. VocÃª Ã© o Ãºnico jogador neste jogo, entÃ£o vocÃª jÃ¡ Ã© o vencedor. Como isto te faz sentir? Mantenha seus olhos abertos, espere por coisas grandes no seu caminho e elas &lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\ncomeÃ§arÃ£o a vir. Tudo na natureza segue o mesmo princÃ­pio. O ciclo da Ã¡gua, por exemplo; a Ã¡gua que evapora se condensa em nuvens, para depois cair sobre as montanhas em forma de chuva, apenas para descer em corredeiras de volta para o oceano. O oceano persegue os rios para receber a Ã¡gua de volta ou apenas espera que a Ã¡gua retorne? Deixo esta questÃ£o em aberto para os leitores filÃ³sofos. A questÃ£o Ã© se mover em um ciclo natural apÃ³s definir um propÃ³sito, tomar uma aÃ§Ã£o e deixar a natureza seguir o seu curso, trabalhando e sempre evoluindo em seu trabalho, plantando um estado de espÃ­rito de â€œsucessoâ€ que o guiarÃ¡ atravÃ©s dos altos e baixos e o darÃ¡ aquele arrepio de orgulho quando vocÃª olhar para trÃ¡s e pensar: â€œEu consegui!â€&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nEu espero que este artigo tenha sido inspirador. Eu adoraria que vocÃª o compartilhasse e se vocÃª tiver algum tÃ³pico sobre o qual vocÃª gostaria que eu escrevesse, envie-me um e-mail e eu escreverei sobre ele.&lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nGiselle, from Brazil, living in the Netherlands.&lt;/p&gt;&lt;p&gt;\r\n'),
(5, '200520181526809243DHABAN', 'us', 'Succes. Laten we eens in deze ongrijpbare term', 'jkjfoier , qeoiqem, erwrwrqw, ', 'Succes. Laten we eens in deze ongrijpbare term, metafoor of slagzin duiken. Tegenwoordig is het hip, maar wat wordt er echt bedoeld en waarom is het zo ongrijpbaar? &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nAls we naar de etymologie van het woord kijken is de eerste verschijning te traceren naar de jaren 1530. Het woord success komt van het Latijnse â€˜successusâ€™. Toen had het een stuk minder betekenis dan vandaag, toch?&lt;/p&gt;&lt;p&gt;\r\nIn de huidige wereld wordt succes soms gezien als een einddoel. Hij of zijn heeft â€˜het gemaakt,â€™ maar succes is een constante, ontwikkelende geestestoestand. &lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nTerwijl onze persoonlijkheden veranderen gedurende de Jaren, beinvloed door plaatsen, mensen en de rest, verandert success met ons mee. Daarom is succes soms zo moeilijk te verkrijgen, omdat we eigenlijk niet weten wat het is of waar we naar zoeken.  Wanneer draait de wereld en vertelt die je; â€˜Ja, je bent de titel â€˜succesvolâ€™ toegekend. &lt;/p&gt;&lt;p&gt;\r\n&lt;/p&gt;&lt;p&gt;\r\nSucces is een persoonlijke reis, maar verstopt onder al dat succes zit een drive om door de wereld om je heen geaccepteerd en gerespecteerd te worden. Wat als we in een wereld van oneindige spelers leven waar je nooit het respect van je gelijken kan winnen? Als er oneindig veel spelers zijn hoe kun je dan winnen? &lt;/p&gt;&lt;p&gt;\r\nMisschien jagen we illusies na. De eerste stap naar echt succes is zelfacceptatie, genieten van de reis die je kiest tijdens je leven en dankbaar zijn voor de kleine dingen die het leven je tot dusver bracht. Succes wordt dan minder een stip aan de horizon maar steeds meer een drijvende kracht achter je die je met een tank vol dankbaarheid duwt richting meer voldoening gevende ervaringen en momentien in de toekomst (waar je dan weer dankbaar voor kunt zijn). Dit is een ondersteunend duwtje in de rug tijdens je strijd heuvelop in plaats van een fles whisky die voor je bungelt terwijl je in een rolstoel zit.&lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nDe sleutel tot succes is vrij simpele: je moet het niet najagen. Wees blij met de wereld waarin je leeft, de baan die jou koos, de vrienden die jou maakten, en de kansen zullen zichzelf op je pad vertonen.  Bedenk dat het jouw reis is; er is geen prijs voor de mooist geklede. In dit spel ben jij de enige speler dus heb je al gewonnen. Hoe voelt dat? Hou je ogen open en bereid je voor op grote dingen en ze zullen je kant op komen. Alles in de natuur volgt dezelfde cyclus. Neem bijvoorbeeld water, het verdampt tot wolken, later storten die zich op de bergen leeg om dan langs en door die bergen terug naar de oceaan te gaan. Jaagt de oceaan zijn geliefde bezit na of verwacht deze simpelweg dat het komt in veelvoud. Ik zal het aan de filosofen overlaten om daarover te malen. &lt;/p&gt;&lt;p&gt;\r\nHet punt is dat je in een natuurlijke cyclus moet zien te komen door een bestemming te kiezen, iets te doen en dan de natuur zijn gang laten gaan door te geven, ontvangen en constant evolueren werk je met de natuur om een mindset in te bedden die je door de ups-en-downs heen stuurt en achteraf, als jij terugblikt en denkt â€™yes, ik heb het gehaald,â€™ laat gloeien van trots en enthousiasme. &lt;/p&gt;&lt;p&gt;\r\nIk hoop, en verwacht, dat dit korte stukje inspirerend was. Ik zou het fijn vinden als je het deelde en als je nog onderwerpen hebt waarover je wil dat ik schrijf stuur dan even een emailtje en ik ga meteen aan de slag.    &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nSlÃ¡inte&lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nColin&lt;/p&gt;&lt;p&gt;\r\n'),
(6, '200520181526809243DHABAN', 'de', 'Hut ab vor dem KÃ¼nstler. Ich fand diese Grafik ', '', 'Hut ab vor dem KÃ¼nstler. Ich fand diese Grafik so toll, dass ich sie teilen musste. Respekt. :)&lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nErfolg. Lasst uns einmal etwas nÃ¤her mit diesem schwer abgrenzbaren Begriff beschÃ¤ftigen. Man hÃ¶rt ihn mittlerweile Ã¼berall, aber was steckt wirklich dahinter und warum ist er so schwer abzugrenzen? &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nEin kurzer Blick auf die Etymologie dieses Wortes:  erste ErwÃ¤hnungen gehen zurÃ¼ck auf das Jahr 1530, es ist keine Ãœberraschung, dass es aus dem Lateinischen successus abstammt, allerdings war seine Bedeutung damals sicherlich viel geringer als heute â€“ oder etwa nicht?  Erfolg wird heutzutage hÃ¤ufig als Ziel des Lebens gesehen. Jemand â€žhat es geschafftâ€œ. Erfolg ist jedoch eine konstante Entwicklung unseres Geistes. Unsere PersÃ¶nlichkeit Ã¤ndert sich mit der Zeit â€“ beeinflusst durch unsere Umgebung, Mitmenschen und so viel mehr. Erfolg verÃ¤ndert sich mit uns. Aus diesem Grund scheint es uns so schwierig Erfolg zu erreichen, wir wissen nicht wirklich was Erfolg ausmacht bzw. wonach wir streben. Wann dreht sich das Leben jemals zu einem um und sagt: â€žJetzt hast du dir den Titel â€šerfolgreichâ€˜ verdient.â€œ  &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nErfolg ist eine persÃ¶nliche Reise. Der versteckte Antrieb fÃ¼r das Streben nach Erfolgt ist es von der Welt um einen herum akzeptiert und respektiert zu werden. Was wÃ¤re wenn wir in einer â€žSpielweltâ€œ leben wÃ¼rden, in der man niemals den Respekt seiner Mitmenschen gewinnen kÃ¶nnte? Wenn es unendlich viele Spieler gibt, wie sollte man jemals Sieger sein? Vielleicht sind wir wie der Hund, der seinen Schwanz fangen will. Der erste Schritt in Richtung Erfolg ist es sich selbst und die eigen gewÃ¤hlte Reise durch das Leben zu akzeptieren und dankbar fÃ¼r die Kleinigkeiten zu sein, die einem das Leben jeden Tag bringt. Dadurch wandelt sich Erfolg von einem schwer fassbaren Punkt am Horizont ein tÃ¤glicher Antrieb mit einem Tank voller Dankbarkeit, der einem stets neue Erfahrungen und Momente in der Zukunft bringt, fÃ¼r die man dankbar sein kann.  Angenommen man ist an den Rollstuhl gefesselt wÃ¤re dies eine bessere Hilfe den Berg hochzukommen, als eine Whiskeyflasche vor der Nase :) &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nDas Geheimnis hinter Erfolg ist eigentlich ganz einfach. Jage ihm nicht hinterher. Versuche einfach glÃ¼cklich in der Welt zu sein, in der du lebst; in dem Beruf, den du gewÃ¤hlt hast;  mit den Freunden, die du dir ausgesucht hast. Die MÃ¶glichkeiten werden sich dir selbst auf deiner Reise offenbaren. Denke daran: Es ist deine eigene Reise, es wird am Ende keinen Preis fÃ¼r das beste Outfit geben! Du bist der einzige Spieler in diesem Spiel - du bist von Anfang an schon der Gewinner. Wie fÃ¼hlt sich das an? Halte deine Augen offen und die schÃ¶nen Momente werden dir von selbst Ã¼ber den Weg laufen. Alles in der Natur folgt demselben Prinzip â€“ nehmen wir z.B. den Wasserkreislauf:  Wasser verdampft zu Wolken, regnet sich spÃ¤ter auf die Berge ab nur um anschlieÃŸend von den Bergen herunterzuflieÃŸen und wieder im Meer zu landen.  Jagt ihm das Meer wie besessen hinterher oder erwartet es schlicht und einfach seine RÃ¼ckkehr? Ich lasse dies einfach mal offen zum GrÃ¼beln fÃ¼r alle Philosophen. Der Punkt hier ist es in einen natÃ¼rlichen Kreislauf zu kommen, eine Abwechslung aus Entscheiden, Handeln und dann der Natur ihre Freiheiten zu lassen um zu geben, empfangen um dich dabei zu unterstÃ¼tzen eine natÃ¼rliche Einstellung zu einem â€žerfolgreichenâ€œ Geist zu helfen, der dich glÃ¼cklich durch die Hochs und Tiefs des Lebens begleiten wird und dir ein StÃ¼ckchen Aufregung und Stolz verpasst, wenn du einmal zurÃ¼ckblickst und denkst: â€žWir haben es geschafft.â€œ  &lt;/p&gt;&lt;p&gt;\r\n &lt;/p&gt;&lt;p&gt;\r\nIch hoffe, dass dieser kleine Text dich inspiriert hat. Ich wÃ¼rde mich riesig freuen, wenn du ihn teilst. Schick mir einfach eine Mail wenn du mir (zu egal welchem Thema) schreiben mÃ¶chtest â€“ ich werde mich auch sicher gleich melden.'),
(7, '200520181526810626AMSNET', 'us', 'Friends Funny Scene', 'urowq,qwerqwe,trter,qeqeq', ''),
(8, '200520181526810626AMSNET', 'bd', 'à¦«à§à¦°à§‡à¦¨à§à¦¡à¦¸ à¦«à¦¾à¦¨à¦¿ à¦¸à¦¿à¦¨', 'à¦«à§à¦°à§‡à¦¨à§à¦¡à¦¸ ,à¦«à¦¾à¦¨à¦¿,à¦¸à¦¿à¦¨', ''),
(9, '210520181526905557AMSNET', 'us', 'shuprovaaaa', 'shup', 'shuprova shuprova shuprova'),
(10, '210520181526905557AMSNET', 'cm', 'ppj[k[ppasdasd', 'p[', 'qwpqqweasdsdsdsa sd asdasd asd');

-- --------------------------------------------------------

--
-- Table structure for table `contributors`
--

CREATE TABLE `contributors` (
  `CONTRIBUTOR_ID` int(11) NOT NULL,
  `CONTRIBUTOR_NAME` varchar(50) NOT NULL,
  `CONTRIBUTOR_EMAIL` varchar(120) NOT NULL,
  `CONTRIBUTOR_COUNTRY` varchar(150) NOT NULL,
  `CONTRIBUTOR_CITY` varchar(50) NOT NULL,
  `CONTRIBUTOR_PASSWORD` text NOT NULL,
  `CONTRIBUTOR_RATING` varchar(40) DEFAULT NULL,
  `CONTRIBUTOR_ACCOUNT_STATUS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contributors`
--

INSERT INTO `contributors` (`CONTRIBUTOR_ID`, `CONTRIBUTOR_NAME`, `CONTRIBUTOR_EMAIL`, `CONTRIBUTOR_COUNTRY`, `CONTRIBUTOR_CITY`, `CONTRIBUTOR_PASSWORD`, `CONTRIBUTOR_RATING`, `CONTRIBUTOR_ACCOUNT_STATUS`) VALUES
(1, 'Ruhul Mashbu', 'mashbu111@gmail.com', 'Bangladesh', 'Dhaka', 'a999782a5ea449b9941bc3ecfa9a1968821037e9a583d82092da9ff0e6f2314f1c719e7e69ffda69cd6934d69137548a3f8ea9309c9eb47c22422c5153311b3e', '0', 'verified'),
(2, 'Mushfiq Dewan', 'mushfiq20@gmail.com', 'Bangladesh', 'Dhaka', '34c5fb97cb1c24706a5491ee8cf3728336b67e8b4af87163a77c2af3c2f5caa277b51fad08ac4be9d106cb90fe3ac6544a785f7c14ab05e25632b32673ddf547', '0', '5b0148b0cbe7f5b0148b0cbef9'),
(3, ' Colin', 'burrkie@gmail.com', 'Ireland', ' Dublin', 'a8dd9298925d43fde89eca97d497ddaa0a9e986ad0928c750b60e7581bb4aab2ed246d9fca08fa2b71f70622f0819d3ea4dc9210800979fabd25bde98fc56e4b', '0', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

CREATE TABLE `editors` (
  `EDITOR_ID` int(11) NOT NULL,
  `EDITOR_NAME` varchar(50) NOT NULL,
  `EDITOR_EMAIL` varchar(120) NOT NULL,
  `EDITOR_COUNTRY` varchar(150) NOT NULL,
  `EDITOR_CITY` varchar(50) NOT NULL,
  `EDITOR_PASSWORD` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `editors`
--

INSERT INTO `editors` (`EDITOR_ID`, `EDITOR_NAME`, `EDITOR_EMAIL`, `EDITOR_COUNTRY`, `EDITOR_CITY`, `EDITOR_PASSWORD`) VALUES
(1, 'Collin Burke', 'collin@yahoo.com', 'Netherland', 'Amsterdam', '675cc5ad6492877717845bb991c2df362f985a9c24119bf6fd292d1dbe3726588c3b901d3738ff576e6e4fd598ac90b5c5ad11a2f7e4ce145cbacc267a3171d1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`TABLE_ID`);

--
-- Indexes for table `article_translations`
--
ALTER TABLE `article_translations`
  ADD PRIMARY KEY (`TABLE_ID`);

--
-- Indexes for table `contributors`
--
ALTER TABLE `contributors`
  ADD PRIMARY KEY (`CONTRIBUTOR_ID`);

--
-- Indexes for table `editors`
--
ALTER TABLE `editors`
  ADD PRIMARY KEY (`EDITOR_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `TABLE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `article_translations`
--
ALTER TABLE `article_translations`
  MODIFY `TABLE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contributors`
--
ALTER TABLE `contributors`
  MODIFY `CONTRIBUTOR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `editors`
--
ALTER TABLE `editors`
  MODIFY `EDITOR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

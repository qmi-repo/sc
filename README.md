Stardust Connect Client v1.x
==========
# Requisiti minimi di sistema
[![php version](https://img.shields.io/badge/php-5.6.31-blue.svg)]() 

Installare la libreria tramite composer
-
È possibile installare il client attraverso composer modificando il composer.json come da esempio
```json
{
    "repositories" : [
        ...
        {
            "type": "vcs",
            "url": "git@gitlab.qmi.it:qmi-libs/stardust-connect-client.git"
        },
        ...
    ],
    ...
}
```
Poi, eseguire su terminale:
```bash
composer require qmi-libs/stardust-connect-client
```
Installazione completata.

Esempio Stardust Connect
-
```php
<?php
namespace App\Controller;

use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Repository\CinemaRepository;
use QMILibs\StardustConnectClient\Repository\HobbyRepository;
use QMILibs\StardustConnectClient\Repository\MovieGenreRepository;
use QMILibs\StardustConnectClient\Repository\MovieRepository;
use QMILibs\StardustConnectClient\Repository\PostRepository;
use QMILibs\StardustConnectClient\Repository\UserCellphoneRepository;
use QMILibs\StardustConnectClient\Repository\UserProfileRepository;
use QMILibs\StardustConnectClient\Repository\UserSocialRepository;
use QMILibs\StardustConnectClient\StardustApp;

class StardustConnectController
{
    /**
     * Route like "/stardust-connect"
     * @throws \Exception
     */
    public function stardustConnectAction()
    {
        $clientId = getenv("STARDUST_APP_ID"); //Imposta un App
        $appSecret = getenv("STARDUST_APP_SECRET");

        $client = new Client(new StardustApp($clientId, $appSecret));
        //Impostiamo come redirect URL questa pagina stessa
        //(ricordati di inserire il redirect URL nelle impostazioni dell'App Stardust)
        $redirectUrl = "https://www.yournicewebsite.it/stardust-connect"; //Ovviamente, è meglio che il valore di questa variabile sia generato da un Routing

        //Se l'utente ha rifiutato l'autorizzazione
        if (isset($_GET['stardust_connect_denied'])) { // oppure $this->input->get('stardust_connect_denied', false); in codeigniter e $request->query->get("stardust_connect_denied") in Symfony
            /* ... Mostra un messaggio all'utente che lo informa che non può continuare senza effettuare lo stardust connect ... */
        }

        //Se l'utente ha autorizzato il connect
        if (isset($_GET['code'])) { // oppure $this->input->get('code', false); in codeigniter e $request->query->get("code") in Symfony
            $token = $client->getAccessToken($redirectUrl, $_GET['code']);

            //Ottenuto il token, è possibile salvarlo in sessione o sul DB per non richiedere nuovamente la risorsa e intasare Stardust di chiamate
            /* ... inserisci qui il codice per salvare il tuo token ... */

            //Ricreo il client con il token (così avrà l'accesso ai repository)
            $client = new Client(new StardustApp($clientId, $appSecret), [
                'access_token'       => $token->getToken(),
            ]);

            //Ecco come è possibile poi richiedere le informazioni tramite il client
            $data = [];
            $userProfileRepo = new UserProfileRepository($client);
            $data['profile'] = $userProfileRepo->getUserProfile();

            $cinemaRepository = new CinemaRepository($client);
            $data['cinema'] = $cinemaRepository->getUserFavoriteCinemas();

            $hobbyRepository = new HobbyRepository($client);
            $data['hobby'] = $hobbyRepository->getUserHobbies();

            $movieGenreRepository = new MovieGenreRepository($client);
            $data['movieGenre'] = $movieGenreRepository->getUserFavoriteMovieGenres();

            $movieRepository = new MovieRepository($client);
            $data['movie'] = $movieRepository->getUserFavoriteMovies();

            $postRepository = new PostRepository($client);
            $data['post'] = $postRepository->getUserFavoritePosts();

            $userCellphoneRepository = new UserCellphoneRepository($client);
            $data['userCellphone'] = $userCellphoneRepository->getUserCellphone();

            $userSocialRepository = new UserSocialRepository($client);
            $data['userSocial'] = $userSocialRepository->getUserSocial();
        }

        //Per ottenere l'URL di Stardust Connect
        $loginUrl = $client->getLoginUrl($redirectUrl);
    }
}
```

Opzioni per il client
-
Quando crei il Client, il secondo parametro del costruttore è relativo alle sue opzioni. 
```php
<?php
$options = [/* ... */];
$client = new Client(new StardustApp($clientId, $appSecret), $options);
```

| Option | type | Default | Description |
| :--- | :--- | :--- | :--- |
| `access_token`| `NULL`,`string` | NULL | Token da utilizzare per le chiamate verso i dati sensibili. Non impostare questa opzione darà accesso solo alle funzioni base del client come la creazione di un URL per il connect. |
| `stardustConnectUrl`| `string` | `https://www.stardust.it/stardust-connect` | Indirizzo su stardust per effettuare lo stardust connect. Se si vuole utilizzare il client verso *l'ambiente di staging*, impostare a `https://staging.stardust.it/stardust-connect` |
| `host`| `string` | `www.stardust.it` | Host di base di stardust. Se si vuole utilizzare il client verso *l'ambiente di staging*, impostare a `staging.stardust.it` |
| `adapter_config`| `array` | `[]` | L'array di configurazione impostato verrà passato direttamente al client HTTP utilizzato (nel nostro caso, Guzzle). Nel caso in cui l'https del sito host a cui si punta non sia verificato, è possibile impostare `['verify' => false]`|


Il client presenta altre opzioni non documentate in questo README. È possibile consultarle tutte nella nel metodo `QMILibs\StardustConnectClient\Client::configureOptions`.
La documentazione verrà espansa su richiesta via via che sarà necessario.
# diffchecker

An object oriented class for the DiffChecker tool.

Website: [https://diffchecker.com](https://www.diffchecker.com/)

These classes utilise the DiffChecker API. In order to use this, you will require an account ([Sign up here](https://www.diffchecker.com/signup)).

## Namespace
`pxgamer\DiffChecker`

## Classes
`pxgamer\DiffChecker\Config`  
- ::BASE_URL (The main website URL for DiffChecker, this is used when returning links to the created Diff.)
- ::API_URL (The API URL for DiffChecker, this is used in the API calls.)

`pxgamer\DiffChecker\Command\Authorise`  
- configure() (This is used by Symfony console)
- execute() (This is used by Symfony console)
- ::authorise($email, $password) (This is the static authorisation function used to retrieve an access token.)

`pxgamer\DiffChecker\Command\DiffChecker`  
- configure() (This is used by Symfony console)
- execute() (This is used by Symfony console)
- ::diff($file_1, $file_2, $expires = 'forever') (This is the static diff function used to create a new Diff between 2 files.)
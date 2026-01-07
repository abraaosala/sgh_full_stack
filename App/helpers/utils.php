<?php

use App\classes\Config;
use App\classes\Csrf;
use App\classes\FileManager;
use App\classes\FlashMessage;
use App\classes\Password;
use App\classes\Session;
use App\classes\SessionClass;
use App\classes\Validator;
use App\Controllers\Web\ErrorPage;
use App\Dao\Entity\Entity;
use App\Dao\Entity\UserEntity;
use App\Dao\Models\Especialidade;
use App\Dao\Models\Model;
use App\Dao\Models\Perfil;
use App\Dao\Models\Provincia;
use App\Models\User; // Eloquent Model
use App\Http\Response;
// use App\library\Etapa; // Class not found
use App\library\PostOld;
use core\Router;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Redirect;
use App\helpers\ViewHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;

if (!function_exists('dd')) {
    function dd(mixed ...$value): mixed
    {
        echo '<pre>';
        var_dump(...$value);
        echo '</pre>';
        exit;
    }
}

// ------------------------------------------------------------
if (!function_exists('dump')) {
    function dump(mixed ...$value): void
    {
        echo '<pre>';
        var_dump(...$value);
        echo '</pre>';
    }
}

// ------------------------------------------------------------

function getClassShorName(object|string $class): string
{
    $reflect = new ReflectionClass($class);

    return $reflect->getShortName();
}

// ------------------------------------------------------------

function getNames(object|string $class): string
{
    $reflect = new ReflectionClass($class);

    return $reflect->getNamespaceName();
}

// ------------------------------------------------------------
function lnk(string $rota = '', bool $bar = false): string
{
    $base = root();

    return  $bar ? sprintf('%s/%s', $base, $rota) : $base . $rota;
}

// ------------------------------------------------------------

function logged(): bool
{
    /*     return session->has(); */
    return session()->has();
}

// ------------------------------------------------------------
function router(Router $router)
{
    

    $uri= $router->getUri();

    try {
        return $router->router();
    } catch (Throwable $throwable) {
        if (str_contains((string) $uri, 'api')) {
            response()->json([
                'success'=>false,
                'detail'=> $throwable->getMessage(),
                'line'=> $throwable->getLine(),
                'trace'=> $throwable->getTrace()

            ], 400);
        }else{

            (new ErrorPage())->in(404, $throwable);
            exit;
        }
    }
}

// -------------------------------------------------------------
function upper(string $value): string
{
    return strtoupper($value);
}

// -------------------------------------------------------------
function lower(string $value): string
{
    return strtolower($value);
}

// -------------------------------------------------------------
function ucf(string $value): string
{
    return ucfirst($value);
}

// ------------------------------------------------------------

function safeEnv()
{
    // Habilitar Variavels do Ambiente
    $dir = dirname(__DIR__, 2);
    $dotenv = Dotenv::createUnsafeImmutable($dir);

    return $dotenv->safeLoad();
}

// ------------------------------------------------------------
if (!function_exists('env')) {
    // code...
    function env(string $name, $default = null): mixed
    {
        $name = strtoupper($name);
        if (!array_key_exists($name, getenv())) {
            return $default;
        }

        // return  $_ENV[$name];
        return getenv($name);
    }
}

// ------------------------------------------------------------

// ------------------------------------------------------------
/**
 * sanitização de dados vindo do Usuario.
 */
function sanitizeInput($data)
{
    if (is_array($data)) {
        // Se for um array, aplicamos a sanitização recursivamente
        return array_map(sanitizeInput(...), $data);
    } else {
        // Remover espaços em branco no início e no final
        $data = trim((string) $data);
        // Remover barras invertidas
        $data = stripslashes($data);
        // Converter caracteres especiais para HTML
        $data = htmlspecialchars($data);

        return $data;
    }
}

// ------------------------------------------------------------
function globals(?array $data = [])
{
    $data['sistem'] = APP['NAME'];
    $data['hospital'] = HOSPITAL;

    $data['description'] ??= APP['NAME'];
    $data['dev'] = ucfirst((string) APP['DEVOLOPER']);

    $data['site'] = root();

    // prefixo da uri
    $prefix = [
        'admin',
        'medico',
        'secretario',
        'enfermeiro',
        'paciente',
    ];
    if (logged()) {

        $id = session()->get('id');
        $perfil = session()->get('perfil');

        // dd(session->dump());
        $data['id'] = $id;

        // Eloquent Refactor: Get User directly
        $user = User::select('id', 'nome', 'email', 'perfil', 'genero', 'criado_em')
            ->find($id);

        if ($user) {
            $perfil = $user->perfil;
            $data['perfil'] = $perfil;
            $data['perfils'] = $prefix;
        } else {
            // Fallback or Logout if user not found
            // session()->logout(); // Optional: force logout
            $perfil = null;
        }

        // $perfil = (new Perfil())->findById($perfil) ?? '';

        // code...

        if (!in_array($perfil, ['admin', 'superadmin', 'recepcionista', 'enfermeiro'])) {
            $perfilModel = model($perfil);
            if (!class_exists($perfilModel)) {
                throw new \Exception(sprintf('O Model do %s não foi encontrado', $perfil));
            }

            $perfilUser = (new $perfilModel())
                ->select()
                // ->join(Especialidade::class, "$perfil.", '=', 'especialidades.id')
                ->where('usuario_id', '=', $id)
                ->toSql() ?? '';
            $data['auth'] = userPerfil($id, $perfil);
            // dd($perfilUser);
        }

        // ==========================================
        // ==========================================

        $data['auth'] = $user;
        // dd($user);
    }

    $data['yearApp'] = date('Y');

    return $data;
}

function data(?array $data = [])
{
    $data['sistem'] = APP['NAME'];

    $data['description'] ??= APP['NAME'];
    $data['dev'] = ucfirst((string) APP['DEVOLOPER']);

    $data['site'] = root();

    // prefixo da uri
    $prefix = [
        'admin',
        'medico',
        'secretario',
        'enfermeiro',
        'paciente',
    ];
    if (logged()) {
        // ==========================================
        /*    $id = session->get('id');
        $perfil = session->get('perfil'); */
        $id = session()->get('id');
        $perfil = session()->get('perfil');

        // dd(session->dump());
        $data['id'] = $id;

        // Eloquent Refactor: Get User directly
        $user = User::select('id', 'nome', 'email', 'perfil', 'genero', 'criado_em')
            ->find($id);

        if (!$user) {
            session()->logout();
        } else {
            $perfil = $user->perfil;
            $data['perfil'] = $perfil;
            $data['perfils'] = $prefix;
        }

        // $perfil = (new Perfil())->findById($perfil) ?? '';

        // code...

        if (!in_array($perfil, ['admin', 'superadmin', 'recepcionista', 'enfermeiro']))
        // if ($perfil !== 'admin' && $perfil !== 'superadmin')
        {
            $perfilModel = model($perfil);
            if (!class_exists($perfilModel)) {
                throw new \Exception(sprintf('O Model do %s não foi encontrado', $perfil));
            }

            $perfilUser = (new $perfilModel())
                ->select()
                // ->join(Especialidade::class, "$perfil.", '=', 'especialidades.id')
                ->where('usuario_id', '=', $id)
                ->toSql() ?? '';
            $data['auth'] = userPerfil($id, $perfil);
            // dd($perfilUser);
        }

        // dd($perfilUser);
        // dd($user);
        // $user->perfil = $perfil;
        // ==========================================
        // ==========================================

        $data['auth'] = $user;
        // dd($user);
    }

    $data['yearApp'] = date('Y');

    return $data;
}

function userPerfil(int $id, string $perfil, array|string $fields = ['*'])
{
    $perfilModel = model($perfil);
    // $data['userPerfil'] = $perfilUser;
    return (new $perfilModel())
        ->select($fields)
        ->where('usuario_id', '=', $id)
        // ->join(User::class, "{$perfil}s.usuario_id", '=', 'usuarios.id')
        // ->join(Provincia::class, "{$perfil}s.provincia_id", '=', 'provincias.id')
        // ->join(Especialidade::class, 'medicos.especialidade_id', '=', 'especialidades.id')
        ->first();
}

// ------------------------------------------------------------
function userPerfilMed(int $id, string $perfil, array|string $fields = ['*'])
{
    $perfilModel = model($perfil);
    // $data['userPerfil'] = $perfilUser;
    return (new $perfilModel())
        ->select($fields)
        ->where('usuario_id', '=', $id)
        ->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')
        ->join(Provincia::class, 'medicos.provincia_id', '=', 'provincias.id')
        ->join(Especialidade::class, 'medicos.especialidade_id', '=', 'especialidades.id')
        ->first();
}

function model(string $name): string
{
    return NAMESPACE_MODEL . ucfirst($name);
}

// ------------------------------------------------------------
/**
 * Exibe uma ou mais mensagens flash em alert.
 *
 * @param string|array $key chave ou array de chaves
 *
 * @return string|array
 */
function flash(string|array $key): string
{
    if (is_array($key)) {
        return implode('', array_map(FlashMessage::display(...), $key));
    }

    return FlashMessage::display($key);
}

// ------------------------------------------------------------
/**
 * Exibe uma ou mais mensagens flash.
 *
 * @param string|array $key chave ou array de chaves
 *
 * @return string|array
 */
function flashMessage(string|array $key): string
{
    if (is_array($key)) {
        return implode('', array_map(FlashMessage::message(...), $key));
    }

    return FlashMessage::message($key);
}

// ------------------------------------------------------------

function divAlert($content, $type)
{
    return ViewHelper::divAlert($content, $type);
}

// ------------------------------------------------------------
/* PROCURAR USUARIO NA DB */
/* CHECAR SENHA COM HASH */
/**
 * Redirecionamento junto flass message
 *
 * @param array|null $flass [$key, $message, $type]
 * $type com default 'success'
 */
function redirect(string $redirect = '', ?array $flass = []): void
{
    $root = root();
    if ($flass !== null && $flass !== []) {
        [$chave, $messagem, $tipo] = $flass;
        FlashMessage::set($chave, $messagem, $tipo ?? 'success');
    }

    header(sprintf('location:%s%s', $root, $redirect));
    exit;
}

// ------------------------------------------------------------
/**
 * Itera Os Erros Achados no Validador.
 */
function iteraErrorValidator(array $errors): string
{
    $message = '';

    foreach ($errors as $position)
        foreach ($position as $value)
            // $message .= "Erro de grupo {$group} : {$value} ";
            $message .= sprintf(' %s <br> ', $value);

    // $message .= '';


    return $message;
}

// ------------------------------------------------------------

function view(string $filename, bool $include = true)
{
    return ViewHelper::view($filename, $include);
}

// ------------------------------------------------------------
// vericar o comprimento do texto
// ------------------------------------------------------------
// vericar o comprimento do texto
function reviewMaxLenContent(string $content, int $max = 100)
{
    return ViewHelper::reviewMaxLenContent($content, $max);
}

// ------------------------------------------------------------

function totalRecords($model): int
{
    return (new $model())->count()->total;
}

// ------------------------------------------------------------
/*            Limitar O Cadastro de Admin & SuperAdmim        */
// ------------------------------------------------------------
function limiteCad($perfil, User $model, string $redirect)
{
    // if (!in_array($perfil, $perfis))
    //     throw new \Exception("Perfil não corresponde ao Conjunto");

    $perfilAny = $model->findbyPerfil($perfil, "COUNT(*) as total")->total;

    if ($perfil == 'superadmin' && $perfilAny == 1) {
        // PostOld::set($_POST);
        redirect($redirect, ['error', 'Já excedeu O cadastro ou Alteração de SuperAdmin', 'info']);
    }

    /* Verificar se já existe um admin - O sistema só permite 2 */
    if ($perfil == 'admin' && $perfilAny == 2) {
        # code...
        //  PostOld::set($_POST);
        //  PostOld::clean();
        redirect($redirect, ['error', 'Já excedeu O cadastro ou Alteração de Admin', 'info']);
    }
}

// ------------------------------------------------------------
function countDataMoth(string|object $model, $id, $month, $year)
{
    $model = (new $model());

    $params = [
        ':month' => $month,
        ':year' => $year,
        ':user' => $id,
    ];

    /* =================================== */
    $sql = 'SELECT  count(*) as total
            FROM ' . $model->getTable();
    $sql .= ' WHERE
              user_id = :user AND
              month(created_at) = :month AND
              year(created_at) = :year

              ';

    /* =================================== */
    return $model->read($sql, $params);
}

// ------------------------------------------------------------

function Permition(): bool
{
    if (!logged()) {
        $_SESSION['error'] = 'Faça Login Primeiro';
        redirect('login');
    }

    if (session()->get('level') != 1) {
        $_SESSION['error'] = 'Sem Permissão, Contacte Adm';
        redirect();
    }

    return true;
}

// ------------------------------------------------------------
/**
 * Sessao por etapas.
 */
function etapas()
{
    // $etapas = Etapa::get();
    // return $etapas;
    return [];
}

// ------------------------------------------------------------

// ------------------------------------------------------------


// ------------------------------------------------------------
function json_data($data)
{
    $data = array_map(function ($value) {
        if ($value instanceof Entity) {
            return $value->getAtributes();
        }

        return $value;
    }, $data);

    return json_encode($data);
}

// ------------------------------------------------------------
function password_verify_plus($password, $hash)
{
    // mensagem de erro de credenciais
    $error = message('error')[0];
    if (!password_verify((string) $password, (string) $hash)) {
        // code...
        // FlashMessage::set('error', "");
        return $error;
    }

    return true;
}

// ------------------------------------------------------------
function message($key = null)
{
    $message = [];
    $message['error'][] = 'Credencias Erradas';
    $message['success'][] = 'Cadastrado com Sucesso';

    if (!empty($key)) {
        return $message[$key];
    }

    return $message;
}

function  config(): Config
{
    $instance = null;
    if (is_null($instance)) {
        $instance = new Config();
    }

    return $instance;
}

function root(): string
{
    return rtrim(dirname((string) $_SERVER['PHP_SELF']), '\\') . '/';
    // return  "/sgh/";
}


// ------------------------------------------------------------
/**
 * Chamar o Front End.
 */
function asset(string|array $filename, bool $ui = false): array|string
{
    return ViewHelper::asset($filename, $ui);
}

// ------------------------------------------------------------
/**
 * Chamar o Front End da UI.
 */

// ------------------------------------------------------------
function assetLink(string|array $filename, $ui = false): iterable|string
{
    return ViewHelper::assetLink($filename, $ui);
}

function assetJs(iterable|string $filename, bool $ui = false): string|iterable
{
    return ViewHelper::assetJs($filename, $ui);
}

// ------------------------------------------------------------
function old($key, $default = '')
{
    if (!empty($default)) {
        return sanitizeInput($default);
    } elseif (PostOld::has($key)) {
        return sanitizeInput(PostOld::get($key));
    }
}

// ------------------------------------------------------------

/**
 * Tratar ser username.
 */
function username(string $username): string
{
    $username = ltrim($username, '@');

    return strtolower($username);
}

// ------------------------------------------------------------

/**
 * Gerar Token.
 */
function token_generate_by_time(int $plus = 900): iterable
{
    $token = bin2hex(random_bytes(16));
    $expira = date('Y-m-d H:i:s', time() + $plus);

    return [
        $token,
        $expira,
    ];
}

// ------------------------------------------------------------


/**
 * Conversao pelo json e base 24.
 *
 * @return string
 */
function encode_json_base24(array $value)
{
    // json
    $encode = json_encode($value);

    return base64_encode($encode);
}

// -------------------------------------------------------------
function decode_base24_json(string $value): object
{
    $decode = base64_decode($value);

    return json_decode($decode);
}

// -------------------------------------------------------------
function level(int $int): string
{
    return match ($int) {
        0 => 'Super Usuario',
        1 => 'Director',
        2 => 'Secretário'
    };
}

// -------------------------------------------------------------
function avatar_url(string $name, string $background = '6f42c1', int $size = 64): string
{
    return "https://ui-avatars.com/api/?name=" . urlencode($name ?? 'User') . sprintf('&background=%s&color=fff&size=%d', $background, $size);
}

// -------------------------------------------------------------
/**
 * Filtrar users  baseado no in.
 *
 * @param array $incluindo key 1 => Recebe o field ou caluna onde será procurado
 *                         2 => Recebe os valores
 */
function find_users_include(string|object $model, array $incluindo = [], string $fields = '*'): iterable
{
    [$field, $value] = $incluindo;
    if (!is_object($model)) {
        $model = new $model();
    }

    return $model->findIn($field, $value);
}

// -------------------------------------------------------------

function filter_users_exclude(array $all, ?string $exclude = null)
{
    return array_filter(
        $all,
        fn($data) => $data->id != $exclude
    );
}

// -------------------------------------------------------------
function csrf_field(): string
{
    return (new Csrf())->field();
}

// -------------------------------------------------------------

function dataTablesAll(iterable $datas, array $fields, ?array $plus = null)
{
    $data = [];
    foreach ($datas as $key => $item) {
        $res = [];
        $res[] = $key + 1;
        foreach ($fields as $field) {
            $res[] = $item->$field;
        }

        if ($plus !== null && $plus !== [] && is_array($plus)) {
            foreach ($plus as $more) {
                $res[] = $more;
            }
        }

        $data[] = $res;
    }

    // if ($json) {
    //     return Request::json($data);
    // }
    return $data;
}

// -------------------------------------------------------------

function entity_data_itera($data, string|Model $model)
{
    foreach ($data as $key => $value) {
        // Ignora valores vazios (null, '', etc.)
        if (!empty($value)) {
            $model->setEntity()->$key = $key == 'senha' || $key == 'password' ? Password::hash($value) : $value;
        }
    }
}

function entity_itera($data, $entity)
{
    foreach ($data as $key => $value) {
        // Ignora valores vazios (null, '', etc.)
        // if (!empty($value)) {
        $entity->$key = $value;
        // }
    }
}


function status(int $id, int $status): string
{
    return match ($status) {
        0 => sprintf("<a href= 'customer/%d/status/on' title='Ativar'>Desativado</a>", $id),
        1 => sprintf("<a href= 'customer/%d/status/off' title='Desativar'>Ativado</a>", $id)
    };
}

// -------------------------------------------------------------

// -------------------------------------------------------------
/**
 * Chegar se existe valor na Tabela pelo Id.
 */
function check_on_table(string|Model $model, int $id): bool
{
    if (!is_object($model)) {
        $model = new $model();
    }

    return (bool) $model->findById($id);
}

// -------------------------------------------------------------
function iViewForm(string $file)
{
    $path = VIEW . 'form/';
    $file .= '.php';
    if (!file_exists($path . $file)) {
        throw new Exception(sprintf("<p class='text-center'>O Ficheiro %s não foi encontrado no directorio %s </p>", $file, $path), 1);
    }

    return $path . $file;
}

function components(string $filename, $extension = '.php')
{
    $dir = VIEW . '/components/';
    if (!file_exists($dir . $filename . $extension)) {
        throw new Exception(sprintf("<p class='text-center'>O Ficheiro %s não foi encontrado no directorio %s </p>", $filename, $dir), 1);
    }

    return $dir . $filename . $extension;
}

function error_msg($field)
{
    if (isset($_SESSION['input_errors'][$field])) {
        // Retrieve and Unset to show only once
        $msg = $_SESSION['input_errors'][$field][0] ?? $_SESSION['input_errors'][$field];
        // unset($_SESSION['input_errors'][$field]); // Optional: unset if we want flash-like behavior per field
        return '<div class="text-danger small mt-1"> * ' . $msg . '</div>';
    }

    return '';
}

function clear_errors() {}


function paginate_links(LengthAwarePaginator $paginator)
{
    if ($paginator->lastPage() < 2) {
        return '';
    }

    $window = UrlWindow::make($paginator);

    $elements = [
        $window['first'],
        is_array($window['slider']) ? '...' : null,
        $window['slider'],
        is_array($window['last']) ? '...' : null,
        $window['last'],
    ];

    $html = '<nav><ul class="pagination pagination-sm justify-content-center">';

    // Previous Page Link
    if ($paginator->onFirstPage()) {
        $html .= '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
    } else {
        $html .= '<li class="page-item"><a class="page-link" href="' . $paginator->previousPageUrl() . '" rel="prev">&laquo;</a></li>';
    }

    // Pagination Elements
    foreach ($elements as $element) {
        if (is_string($element)) {
            $html .= '<li class="page-item disabled"><span class="page-link">' . $element . '</span></li>';
        }

        if (is_array($element)) {
            foreach ($element as $page => $url) {
                if ($page == $paginator->currentPage()) {
                    $html .= '<li class="page-item active"><span class="page-link">' . $page . '</span></li>';
                } else {
                    $html .= '<li class="page-item"><a class="page-link" href="' . $url . '">' . $page . '</a></li>';
                }
            }
        }
    }

    // Next Page Link
    if ($paginator->hasMorePages()) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $paginator->nextPageUrl() . '" rel="next">&raquo;</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
    }

    return $html . '</ul></nav>';
}


function calcularIdade($dataNascimento)
{
    $dataNascimento = new DateTime($dataNascimento);
    $hoje = new DateTime();

    return $hoje->diff($dataNascimento)->y;
}

/**
 * Gerar Código de Usuário.
 *
 * Esta função gera um código único para o usuário, com um prefixo e um número aleatório de 6 dígitos.
 * O código gerado é verificadhelo para garantir que não exista no banco de dados.
 *
 * @param string $prefix - O prefixo para o código (default: 'CODE')
 * @param Model  $model  - Instância do modelo para a consulta ao banco de dados
 *
 * @return string - Retorna o código gerado no formato PREFIXO-NUMERO
 */
function generateCodeUser(Model $model, $prefix = 'CODE'): string
{
    // Garantir que o prefixo esteja em maiúsculas
    $prefix = strtoupper($prefix);

    // Variável para armazenar o código gerado
    $userCode = '';

    // Loop para garantir que o código gerado seja único
    do {
        // Gerar um número aleatório de 6 dígitos
        $randomNumber = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Concatenar o prefixo e o número aleatório
        $userCode = sprintf('%s-%s', $prefix, $randomNumber);

        // Verificar se o código já existe no banco de dados
        // Aqui estamos utilizando o método first() que retorna o primeiro item da consulta ou null se não encontrado
        $exists = $model->select()->where('codigo', '=', $userCode)->first();
    } while (!empty($exists)); // Se o 'exists' não estiver vazio, significa que o código já existe

    return $userCode;
}

function getUser($model, int $id): ?object
{
    if (!is_object($model)) {
        $model = new $model();
    }

    // dd($model);
    // Verifica se o ID é válido
    if ($id <= 0) {
        return null; // Retorna null se o ID for inválido
    }

    // dd($id);
    // Busca o usuário pelo ID
    $user = $model->findById($id);

    // Retorna o usuário ou null se não encontrado
    return $user ?: null;
}

function manager(): FileManager
{
    return new FileManager();
}

function levelBadge($perfil)
{
    // cores
    $cores = [
        'superadmin' => 'bg-success',
        'admin' => 'bg-success',
        'medico' => 'bg-danger',
        'doutor' => 'bg-danger',
        'enfermeiro' => 'bg-primary',
        'recepcionista' => 'bg-warning text-dark',
    ];
    $cor = $cores[$perfil] ?? 'bg-secondary';
    $perfil = htmlspecialchars((string) $perfil);

    return sprintf("<span class='badge  %s'>%s</span>", $cor, $perfil);
}

function fileManager(): FileManager
{
    return new FileManager();
}


function verifyPasswordGenerate($id, $perfil)
{

    $user = (new User())->findById($id, 'id, senha_gerada as gerado');
    return $user->gerado == 1;
}

function validator($data): Validator
{
    return new Validator($data);
}


function session(): SessionClass
{
    return new SessionClass();
}

function genero(string $gen): string
{
    return match ($gen) {
        'M' => 'Masculino',
        'F' => 'Femenino',
        'O' => 'Outro',
    };
}

function agendaStatus(string $tyle): string
{
    return
        match ($tyle) {
            'C' => 'Agendada',
            'R' => 'Concluida',
            'X' => 'Cancelada',
            'F' => 'Falhou'
        };
}

function DoctorTitle(string $gen): string
{

    return match ($gen) {
        'M' => 'Dr',
        'F' => 'Dra.',
        default => 'Mr'
    };
}

function gerarCodigo()
{
    $letras = range('A', 'Z');
    $numeros = range(0, 9);

    // Padrão: Letra-Número-Letra-Numero
    $grupo1 = $letras[array_rand($letras)] .
        $numeros[array_rand($numeros)] .
        $letras[array_rand($letras)] .
        $numeros[array_rand($numeros)];

    // Grupo de 4 números
    $grupo2 = '';
    for ($i = 0; $i < 4; $i++) {
        $grupo2 .= $numeros[array_rand($numeros)];
    }

    return $grupo1 . '-' . $grupo2;
}

function convertData(mixed $data)
{
    /*   if (!is_array($data)) {
            return $data;
        } */

    if ($data instanceof Entity) {
        // Se for um único objeto Entity
        $data = $data->getAtributes();
    } elseif (is_array($data)) {
        // Se for um array, mapeia normalmente
        $data = array_map(function ($value) {
            if ($value instanceof Entity) {
                return $value->getAtributes();
            }

            return $value;
        }, $data);
    }

    return $data;
}

function gerarIntervalos($horaInicio, $horaFim, $intervalo = '1 hour')
{
    // Converte os horários de início e fim para timestamp
    $horaInicio = strtotime((string) $horaInicio);
    $horaFim = strtotime((string) $horaFim);

    // Converte o intervalo para segundos (por exemplo: 1 hour, 30 minutes, 900 seconds, etc.)
    $intervaloSegundos = strtotime((string) $intervalo, 0);

    // Array para armazenar os intervalos
    $intervalos = [];

    // Enquanto o horário de início for menor que o horário de fim
    while ($horaInicio < $horaFim) {
        $horaFinalIntervalo = $horaInicio + $intervaloSegundos; // Calcula o fim do intervalo
        if ($horaFinalIntervalo <= $horaFim) {
            // Adiciona o intervalo ao array
            $intervalos[] = [date("H:i", $horaInicio), date("H:i", $horaFinalIntervalo)];
        } else {
            break;
        }

        // Atualiza o horário de início para o próximo intervalo
        $horaInicio = $horaFinalIntervalo;
    }

    return $intervalos;
}

/**
 * Processa dados brutos em formato de array para o formato de exportação.
 *
 * @param array $dadosBrutos Um array de arrays associativos vindos da base de dados.
 * @return array Um array bidimensional pronto para a exportação, incluindo o cabeçalho.
 */
function processarDadosParaExportacao(array $dadosBrutos): array
{
    // 1. Verifique se o array está vazio
    if ($dadosBrutos === []) {
        return [];
    }

    $dadosProcessados = [];
    $primeiroItem = $dadosBrutos[0];

    // 2. Extraia o cabeçalho (as chaves do primeiro array)
    // Isso garante que os nomes das colunas estejam na primeira linha.
    $dadosProcessados[] = array_keys($primeiroItem);

    // 3. Itere sobre cada linha para extrair os valores e garantir a compatibilidade
    foreach ($dadosBrutos as $item) {
        // Usa array_values para pegar apenas os valores, eliminando as chaves
        $linha = array_values($item);

        // Garante que todos os valores sejam convertíveis para string
        $linhaLimpa = array_map(function ($valor) {
            // Se for um array ou objeto aninhado, converte para JSON
            if (is_array($valor) || is_object($valor)) {
                return json_encode($valor);
            }

            // Converte qualquer outro valor para string
            return (string) $valor;
        }, $linha);

        $dadosProcessados[] = $linhaLimpa;
    }

    return $dadosProcessados;
}

if (!function_exists('csrf')) {
    /**
     * Retorna a -instância do gerenciador CSRF.
     */
    function csrf(): Csrf
    {
        // Variável estática para manter a instância
        static $instance = null;

        // Se a instância ainda não foi criada, crie-a
        if ($instance === null) {
            $instance = new Csrf();
        }

        // Retorna a mesma instância em todas as chamadas
        return $instance;
    }
}

function sepatateDate(array $data, array $fillable): array
{
    return array_intersect_key($data, array_flip($fillable));
}

function response(): Response
{

    return new Response();
}

function cors($dominioPermitidos = [])
{



    if (!empty($dominioPermitidos)) {
        $origem = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origem, $dominioPermitidos)) {
            // Se estiver, envia o cabeçalho CORS com a origem específica
            header("Access-Control-Allow-Origin: " . $origem);
        }
    } else {
        // 1. Permite que qualquer domínio (*) acesse a API
        header("Access-Control-Allow-Origin: *");
    }

    // 2. Define quais métodos HTTP são permitidos (GET, POST, PUT, DELETE, OPTIONS, etc.)
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    // 3. Define quais cabeçalhos HTTP podem ser usados na requisição (Ex: Authorization, Content-Type)
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    // Opcional: Define a vida útil (em segundos) da resposta pré-voo (preflight)
    header("Access-Control-Max-Age: 3600");

    // Se for uma requisição OPTIONS (preflight), apenas encerra o script após enviar os headers
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}
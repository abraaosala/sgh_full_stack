<?php

namespace App\Controllers\Medical;

use App\classes\Json;
use App\Dao\Entity\AgendaEntity;
use App\Dao\Models\Agenda;
use App\Dao\Models\Especialidade;
use App\Dao\Models\Medico;
use App\Dao\Models\Provincia;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;

class AgendaMedicaController extends Controller
{
    // Métodos padrão de controllers RESTful
    public function index()
    {
        // Listar recursos
        $this->view(globals([
            'title' => 'Minha Agenda',
        ]), 'medico.agenda');
    }

    public function show($params)
    {
        // Exibir um recurso específico
        header(API);

        // ID da agenda a partir dos parâmetros
        $id = (int) $params['agenda'];

        // Busca a agenda do médico com base no ID fornecido
        $agenda = (new Agenda())->select()->where('medico_id', '=', $id)->get();

        // Mapeia os dados no formato esperado pelo FullCalendar
        $eventos = [];

        foreach ($agenda as $evento) {
            $eventos[] = [
                'id' => $evento->id,
                'title' => $evento->title,
                'start' => str_replace(' ', 'T', $evento->start),
                'end' => str_replace(' ', 'T', $evento->end),
                'color' => $evento->color,
            ];
        }

        // Retorna os dados em JSON corretamente
        echo json_encode($eventos);
        exit;
    }

    public function create()
    {
        // criar novo recurso
    }

    public function store()
    {
        // Salvar novo recurso

        $model =  new Agenda(AgendaEntity::class);
        $data = sanitizeInput(json_decode(file_get_contents("php://input"), true));

        //separar
        $medico_id = $data['medico_id'];
        $title = $data['title'];
        $color = $data['color'];
        $start = str_replace('T', ' ', $data['start']);
        $end = str_replace('T', ' ', $data['end']);

        // 
        $model->setEntity()->medico_id = $medico_id;
        $model->setEntity()->title = $title;
        $model->setEntity()->start = $start;
        $model->setEntity()->color = $color;
        $model->setEntity()->end = $end;
        $model->setEntity()->create_time = date('Y-m-d H:i:s');


        Json::convertData($model);
        /* 
        $startime= new DateTime($start);
        $datetime= new DateTime();
       $hoje= $datetime->format('Y-m-d H:i:s');

        
        $def= $datetime->diff($startime); */

        header(API);
        //
        $jData = [];
        if ($end < $start) {
            http_response_code(404);
            // $jData .= ['status' => false, 'mgs' => 'Entrada não pode ser menor saida'];
            $jData['status'] = false;
            $jData['msg'] = 'Saida não pode ser menor que Entrada';
        } else {
            # code...
            $store = $model->store();
            if ($store) {
                http_response_code(202);
                # code...
                $jData['status'] = true;
                $jData['msg'] = 'Evento Cadastrado com Sucesso';
            } else {
                http_response_code(404);
                $jData['status'] = false;
                $jData['msg'] = 'não foi possivel cadastrar o Evento';
            }
        }


        // $data= Json::data();
        //   Json::encode($data);
        Json::encode($jData);
    }

    public function edit($params)
    {
        // Editar recurso existente


    }

    public function update($params)
    {
        $model = new Agenda(AgendaEntity::class);
        // Atualizar recurso existente.
        $data = sanitizeInput(json_decode(file_get_contents("php://input"), true));

        //separar
        $id = $data['id'];
        $title = $data['title'];
        // $color = $data['color'];
        $start = str_replace('T', ' ', $data['start']);
        $end = str_replace('T', ' ', $data['end']);
        $jData = [];

        $model->setEntity()->id = $id;
        $model->setEntity()->title = $title;
        $model->setEntity()->start = $start;
        $model->setEntity()->end = $end;
        // $model->setEntity()->create_time = date('Y-m-d H:i:s');    


        $save = $model->save();

        if ($save) {
            $jData['status'] = true;
            $jData['msg'] = 'Agenda Alterado com Sucesso';
        } else {
            # code...
            $jData['status'] = false;
            $jData['msg'] = 'não foi possivel alterar';
        }

        Json::encode($jData);
    }

    public function delete($params)
    {
        // Deletar recurso
        $model = new Agenda(AgendaEntity::class);
        // Atualizar recurso existente.
        $data = sanitizeInput(json_decode(file_get_contents("php://input"), true));


        //separa
        $id = (int) $data['id'];

        $jData = [];
        $delete = $model->remove($id);
        if ($delete) {
            # code...
            $jData['status'] = true;
            $jData['msg'] = 'Evento Eliminado com Sucesso';
        } else {
            $jData['status'] = false;
            $jData['msg'] = 'Evento não foi Eliminado ';
        }



        echo json_encode($jData);
    }

    public function api()
    {

        $model = new Agenda()->select('agendas.*, usuarios.id as uid, usuarios.email as email, usuarios.nome as medico, especialidades.nome as especialidade, provincias.nome as provincia, medicos.numero_ordem as numero_ordem, medicos.nivel as nivel, medicos.telefone as telefone')->join(Medico::class, 'agendas.medico_id', '=', 'medicos.id');

        if (isset($_GET['id'])) {
            $id = (int) urlencode((string) $_GET['id']);
            $model->where('medico_id', '=', $id);
        }

        $model->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')
            ->join(Especialidade::class, 'medicos.especialidade_id', '=', 'especialidades.id')
            ->join(Provincia::class, 'medicos.provincia_id', '=', 'provincias.id');
        // dd($model->toSql());
        $results = $model->get();

        $assoc = Json::convertData($results);
        $eventos = array_map(fn($item) => [
            'id' => $item['id'],
            'title' => $item['title'],
            'start' => $item['start'],
            'end' => $item['end'],
            'color' => $item['color'],
            'extendedProps' => [
                'medico' => $item['medico'],
                'email' => $item['email'],
                'especialidade' => $item['especialidade'],
                'provincia' => $item['provincia'],
                'numero_ordem' => $item['numero_ordem'],
                'nivel' => $item['nivel'],
                'telefone' => $item['telefone']
            ]
        ], $assoc);


        header(API);
        echo Json::encode($eventos);
    }

    public function storealeatory(){
$response=response();

// --- PASSO 1: Buscar todos os médicos ---
$medicoModel = new Medico();
$todosOsMedicos = $medicoModel->all();

if (empty($todosOsMedicos)) {
    $response->setStatus(404)
        ->setMessage("Nenhum médico encontrado no sistema. Adicione médicos antes de gerar a agenda.");
    $response->send();
    die;
}

// --- PASSO 2: Definir a estrutura dos turnos ---
$turnos = [
    'Matinal' => [
        'inicio' => '08:00:00',
        'fim' => '12:00:00',
        'cor' => '#36b9cc'
    ],
    'Vespertino' => [
        'inicio' => '13:00:00',
        'fim' => '18:00:00',
        'cor' => '#f6c23e'
    ],
    'Noturno' => [
        'inicio' => '19:00:00',
        'fim' => '23:00:00',
        'cor' => '#4e73df'
    ]
];
$nomesDosTurnos = array_keys($turnos);

// --- PASSO 3: Gerar os eventos de turno ---
$quantidadeDeTurnosParaGerar = 30;
$agendaModel = new Agenda(AgendaEntity::class);

for ($i = 0; $i < $quantidadeDeTurnosParaGerar; $i++) {
    // Sorteia um médico da lista
    $medicoSorteado = $todosOsMedicos[array_rand($todosOsMedicos)];
    $medico_id = $medicoSorteado->id;

    // Sorteia um dia aleatório no próximo mês
    $timestampDia = mt_rand(time(), strtotime('+1 month'));
    $diaAleatorio = date('Y-m-d', $timestampDia);

    // Sorteia um dos turnos
    $nomeTurnoSorteado = $nomesDosTurnos[array_rand($nomesDosTurnos)];
    $dadosDoTurno = $turnos[$nomeTurnoSorteado];

    // Monta as variáveis para o evento
    $title = "Turno " . $nomeTurnoSorteado;
    $color = $dadosDoTurno['cor'];
    $start = $diaAleatorio . ' ' . $dadosDoTurno['inicio'];
    $end = $diaAleatorio . ' ' . $dadosDoTurno['fim'];
    
    // --- PASSO 4: VERIFICAÇÃO DE CONFLITO ---
    // A LÓGICA CORRETA PARA DETECTAR QUALQUER TIPO DE SOBREPOSIÇÃO
    // É: "O início do novo turno é anterior ao fim de um turno existente" E "O fim do novo turno é posterior ao início de um turno existente".
    $conflito = $agendaModel->where('medico_id', '=', $medico_id)
        ->andWhere(function ($query) use ($end, $start){
            $query->where('start', '<', $end)
        ->where('end', '>', $start);
        })
        ->first();

    // Se a consulta retornar algo, há um conflito. Pula para a próxima iteração.
    if ($conflito) {
        // Log para debug (opcional)
        // echo "Conflito encontrado para o médico ID {$medico_id} no dia {$diaAleatorio} no turno {$nomeTurnoSorteado}. Pulando.<br>";
        continue;
    }

    // --- PASSO 5: Criar e salvar o turno na agenda (se não houver conflito) ---
    $agendaModel->setEntity()->medico_id = $medico_id;
    $agendaModel->setEntity()->title = $title;
    $agendaModel->setEntity()->start = $start;
    $agendaModel->setEntity()->end = $end;
    $agendaModel->setEntity()->color = $color;
    $agendaModel->setEntity()->create_time = date('Y-m-d H:i:s');

    if ($agendaModel->store()) {
        // echo "{$title} agendado para o médico ID {$medico_id} no dia {$diaAleatorio}.<br>";
    } else {
        $response->setMessage(sprintf('Falha ao criar turno para o médico ID %s.<br>', $medico_id));
    }
}

$response->setMessage("Processo de geração de agenda concluído! Conflitos de horário foram evitados.");
$response->send();
die;}
}
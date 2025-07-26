<?php

include 'connection.php';
global $pdo;

#Inicializando variáveis ^^
$successMsg ='';
$errorMsg = '';
$eventsFromDB = [];



if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === "add"){

    $course = trim($_POST['course_name'] ?? '');
    $instructor = trim($_POST['instructor_name'] ?? '');
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date']?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';

    if ($course && $instructor && $start && $end){
       $stmt = $pdo-> prepare(
                "INSERT INTO appointments (course_name, instructor_name, start_date, end_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)"
            );
        $stmt-> execute([$course, $instructor, $start, $end, $startTime, $endTime]);

        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit;
    } else{
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
        exit;
    }



    #Editar


        if ($_SERVER['REQUEST_METHOD'] === "POST" && ($_POST["action"] ?? '') === 'edit'){

            $id = $_POST["event_id"] ?? null;
            $course = trim($_POST["course_name"] ?? '');
            $instructor = trim($_POST['instructor_name'] ?? '');
            $start = $_POST['start_date'] ?? '';
            $end = $_POST['end_date'] ?? '';
            $startTime = $_POST['start_time'] ?? '';
            $endTime = $_POST['end_time'] ?? '';
        }

            if( $id && $course && $instructor && $start && $end){

                $stmt = $pdo->prepare(
                    "UPDATE appointments SET course_name = ?, instructor_name = ?, start_date = ?, end_date = ?, start_time = ?, end_time = ?  WHERE id = ?"
                );

                $stmt->execute([$course, $instructor, $start, $end, $startTime, $endTime, $id]);

                $stmt->close();

                header("Location: " . $_SERVER["PHP_SELF"] . "?success=2 ");
                exit;
            } else {

                header("Location: " . $_SERVER["PHP_SELF"] . "?error=2 ");
            }




};




#Deletar

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? '') === "delete"){

    $id = $_POST['event_id'] ?? null;

    if ($id){
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt-> execute([$id]);
        header("Location: " . $_SERVER["PHP_SELF"] . "?success=3");
        exit;
    }
};


# Sucesso e Mensagem de erro

if (isset($_GET["success"])){

    $successMsg = match ($_GET["success"]){
        '1' => "Adicionado com Sucesso",
        '2' => "Editado com Sucesso",
        '3' => "Deletado com Sucesso",
        default => ""
};

}


if (isset($_GET["error"])){
    $errosMsg = "Erro! Verifique os dados!";
}



# Listar

$stmt = $pdo->query("SELECT * FROM appointments");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


#Não existe fetch_assoc no pdo como em mysqli
foreach ($rows as $row) {
        $start = new DateTime($row["start_date"]);
        $end = new DateTime($row["end_date"]);

         while ($start <= $end){
            $eventsFromDB[] = [
                'id' => $row['id'],
                "title" => "{$row['course_name']} - {$row['instructor_name']}",
                "date" => $start->format("d-m-Y"),
                "start" => $row["start_date"],
                "end" => $row['end_date'],
                "start_time" => $row["start_time"],
                "end_time" => $row["end_time"]

            ];


            $start -> modify("+1 day");
}



}


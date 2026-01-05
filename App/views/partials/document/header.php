<div class="hospital-header">

    <img src="\public\assets\img\logo.png" class=" hospital-logo">
    <div class="hospital-info">
        <strong>
            <?=sanitizeInput($hospital['name'])??''?>
        </strong>
        <?=sanitizeInput($hospital['street'])??''?>
        <br>
        <?=sanitizeInput($hospital['street'])??''?>
        <br>
        Telefone: <?=sanitizeInput($hospital['tel'])??''?>
        <br>
        E-mail: <?=sanitizeInput($hospital['email'])??''?>

    </div>
    <div class="report-meta">
        <span class="report-title-small"><?=sanitizeInput($title)??''?></span><br>
        Data de Emissão: <?=sanitizeInput($date)??''?><br>
        Hora de Emissão: <?=sanitizeInput($hour)??''?><br>
    </div>
</div>
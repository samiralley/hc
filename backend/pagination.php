<?php
function paginate($query, $perPage, $pdo) {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $totalResults = $stmt->rowCount();
    $totalPages = ceil($totalResults / $perPage);

    return ['totalPages' => $totalPages, 'totalResults' => $totalResults];
}
?>

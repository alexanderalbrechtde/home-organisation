<?php

class WarehouseService
{
    public function edit(string $name, string $category, int $amount): bool
    {
        if ($name === '' || $category === '' || !is_numeric($amount) || filter_var(
                $amount,
                FILTER_VALIDATE_INT
            ) === false) {
            return false;
        }
        $amount = (int)$amount;


        $pdo = new PDO('sqlite:' . __DIR__ . '/../../home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare(
            'INSERT INTO item (name, category, amount) VALUES(:name, :category, :amount)'
        );
        $statement->execute([
            ':name' => $name,
            ':category' => $category,
            ':amount' => $amount
        ]);

        return true;
    }
}
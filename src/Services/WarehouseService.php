<?php

namespace App\Services;

use App\Dtos\ItemDto;
use PDO;

class WarehouseService
{
    public function __construct(private PDO $pdo)
    {
    }

    public function edit(string $name, string $category, int $amount): bool
    {
        if ($name === '' || $category === '' || !is_numeric($amount) || filter_var(
                $amount,
                FILTER_VALIDATE_INT
            ) === false) {
            return false;
        }
        $amount = (int)$amount;


        $statement = $this->pdo->prepare(
            'INSERT INTO item (name, category, amount)
             VALUES(:name, :category, :amount)
             ON CONFLICT(name, category)
             DO UPDATE SET amount = item.amount + excluded.amount'
        );
        $statement->execute([
            ':name' => $name,
            ':category' => $category,
            ':amount' => $amount
        ]);

        return true;
    }

    public function getItems(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT name, category, amount
               FROM item
           ORDER BY name COLLATE NOCASE, category COLLATE NOCASE"
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    private function createItemDto(array $item): ItemDto
    {
        return new ItemDto(
            $item['name'],
            $item['category'],
            $item['amount']
        );
    }
}
<?php
namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;

class QuestionsImport implements ToModel
{
    protected $examId;

    public function __construct($examId)
    {
        $this->examId = $examId;
    }

    public function model(array $row)
    {
        // Abaikan baris pertama jika itu header
        static $isHeader = true;
        if ($isHeader) {
            $isHeader = false;
            return null; // Abaikan header
        }

        $correctOption = strtolower(trim($row[5])); // Kolom F (jawaban benar)

        // Debugging: Menampilkan seluruh nilai baris
        \Log::info('Row Data:', ['row' => $row]);

        // Validasi correct_option agar hanya 'a', 'b', 'c', atau 'd'
        $validOptions = ['a', 'b', 'c', 'd'];

        if (! in_array($correctOption, $validOptions)) {
            // Log error jika correct_option tidak valid
            \Log::error('Invalid correct option:', ['correct_option' => $row[5]]);
            throw new \Exception('Invalid correct option: ' . $row[5]);
        }

        return new Question([
            'exam_id'        => $this->examId,
            'question_text'  => $row[0],        // Kolom A
            'option_a'       => $row[1],        // Kolom B
            'option_b'       => $row[2],        // Kolom C
            'option_c'       => $row[3],        // Kolom D
            'option_d'       => $row[4],        // Kolom E
            'correct_option' => $correctOption, // Kolom F (jawaban benar)
        ]);
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id(); // khóa chính (bảng điểm id)
            $table->unsignedBigInteger('user_id'); // khóa ngoại đến user

            $table->string('subject_name'); // tên môn học

            // Điểm (có thể null vì bạn cho phép để trống để nhập sau)
            $table->decimal('process_score', 4, 2)->nullable(); // QT
            $table->decimal('midterm_score', 4, 2)->nullable(); // GK
            $table->decimal('final_score', 4, 2)->nullable();   // CK

            // Phần trăm trọng số
            $table->unsignedTinyInteger('process_weight')->nullable(); // 0-100
            $table->unsignedTinyInteger('midterm_weight')->nullable();
            $table->unsignedTinyInteger('final_weight')->nullable();

            // Kết quả (điểm tổng KQ)
            $table->decimal('result_score', 4, 2)->default(0); // KQ

            // Trạng thái: đạt / không đạt
            $table->enum('status', ['đạt', 'không đạt'])->default('không đạt');

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
};

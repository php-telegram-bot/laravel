<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    public function up(): void
    {
        Schema::create('chat', static function (Blueprint $table) {
            $table->bigInteger('id')->primary()->comment('Unique user or chat identifier');
            $table->enum('type', ['private', 'group', 'supergroup', 'channel'])->comment('Chat type, either private, group, supergroup or channel');
            $table->char('title')->nullable()->default('')->comment('Chat (group) title, is null if chat type is private');
            $table->char('username')->nullable()->comment('Username, for private chats, supergroups and channels if available');
            $table->boolean('all_members_are_administrators')->nullable()->default(0)->comment('True if a all members of this group are admins');
            $table->timestamps();
            $table->bigInteger('old_id')->nullable()->index('old_id')->comment('Unique chat identifier, this is filled when a group is converted to a supergroup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
}

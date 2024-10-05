<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Thread;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class ThreadControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_deletes_threads_over_1000_posts()
    {
        // テスト用のスレッドと投稿を作成
        $thread = Thread::factory()->create();
        Post::factory()->count(1001)->create(['thread_id' => $thread->id]);

        // 削除操作を実行
        $response = $this->call('DELETE', route('threads.deleteOldThreads'));

        // スレッドが削除されていることを確認
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);

        // ファイルが保存されていることを確認
        $fileName = 'thread_' . $thread->id . '_' . now()->format('Ymd_His') . '.json';
        Storage::disk('local')->assertExists('threads/' . $fileName);
    }

    /** @test */
    public function it_deletes_threads_over_30()
    {
        // テスト用のスレッドを31個作成
        Thread::factory()->count(31)->create();

        // 削除操作を実行
        $response = $this->call('DELETE', route('threads.deleteOverThreads'));

        // 30個を超えるスレッドが削除されていることを確認
        $this->assertCount(30, Thread::all());
    }
}

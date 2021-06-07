<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $saveSuccess = false;
    public $modelId;
    public $post;
    public $title;
    public $body;
    public $photo;
    public $featured_image_caption;
    public $tags, $newTags;
    public $topics, $newTopic;

    public $listeners = [
        'showGeneralSetting' => 'showGeneralSettingModal',
        'showFeatureImage' => 'showFeaturedImageModal',
        'showPublish' => 'showPublishModal',
    ];

    public $modalPostSettingVisible = false;
    public $modalFeatureImageVisible = false;
    public $modalPublishVisible = false;

    /**
     * mount
     *
     * @param  mixed $post
     * @return void
     */
    public function mount($post)
    {
        $this->post = null;

        if ($post) {
            $this->post = $post;

            $this->title = $this->post->title;
            $this->body = $this->post->body;

            $this->modelId = $this->post->id;

            $this->topics = Topic::all()->pluck('name');
            $this->tags = Tag::all()->pluck('name');
        }
    }

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'title' => 'required|min:6',
            'body' => 'required',
        ];
    }

    /**
     * submit
     *
     * @return void
     */
    public function submit()
    {
        $data = [
            'title' => $this->title,
            'body' => $this->body,
            'author_id' => auth()->user()->id,
        ];

        $this->validate();

        if ($this->post) {
            $entry = Post::findOrFail($this->post->id);
            $entry->slug = null;
        } else {
            $entry = new Post();
        }

        $entry->fill($data);

        $entry->save();

        $this->saveSuccess = true;

        return $this->redirectRoute('post.view', $entry->slug);
    }

    /**
     * loadModel
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Post::find($this->post->id);

        $this->title = $data->title;
        $this->body = $data->body;
    }

    /**
     * showGeneralSettingModal
     *
     * @return void
     */
    public function showGeneralSettingModal()
    {
        $this->modalPostSettingVisible = true;
    }

    /**
     * showFeaturedImageModal
     *
     * @return void
     */
    public function showFeaturedImageModal()
    {
        $this->modalFeatureImageVisible = true;
    }

    /**
     * showPublishModal
     *
     * @return void
     */
    public function showPublishModal()
    {
        $this->modalPublishVisible = true;
    }

    public function saveGeneralSettings()
    {
        // Adding Topic
        if ($this->newTopic) {
            $this->post->topic()->sync(
                $this->collectTopic($this->newTopic)
            );
        }

        // Adding Tag
        if ($this->newTags) {
            $this->post->tags()->sync(
                $this->collectTags($this->newTags)
            );
        }

        $this->modalPostSettingVisible = false;
    }

    public function saveImageFeatured()
    {
        $this->validate([
            'photo' => 'image|max:5120', // max 5 MB
        ]);

        if (!empty($this->photo)) {
            $imageHashName = $this->photo->hashName();
        }

        $this->post->update([
            'featured_image_caption' => $this->featured_image_caption,
            'featured_image' => $imageHashName,
        ]);

        $this->photo->store('public/posts/' . $this->modelId . '/featured_image');

        $this->modalFeatureImageVisible = false;
    }

    public function render()
    {
        return view('livewire.post.form');
    }

    private function collectTopic($incomingTopics)
    {
        $allTopics = Topic::all();

        return collect($incomingTopics)->map(function ($incomingTopic) use ($allTopics) {
            $topic = $allTopics->where('name', $incomingTopic)->first();

            if (!$topic) {
                $topic = Topic::create([
                    'name' => $incomingTopic,
                    'user_id' => Auth::user()->id,
                ]);
            }

            return (string) $topic->id;
        })->toArray();
    }

    private function collectTags($incomingTags)
    {
        $allTags = Tag::all();

        return collect($incomingTags)->map(function ($incomingTag) use ($allTags) {
            $tag = $allTags->where('name', $incomingTag)->first();

            if (!$tag) {
                $tag = Tag::create([
                    'name' => $incomingTag,
                    'user_id' => Auth::user()->id,
                ]);
            }

            return (string) $tag->id;
        })->toArray();
    }
}

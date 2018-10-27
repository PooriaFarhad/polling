<div class="form-group">
    <label for="title">Poll Title</label>
    <input class="form-control form-control-lg" type="text" name="title" value="{{ old('title', isset($poll->title) ? $poll->title : null) }}">
</div>
<div class="form-group">
    <label for="content">Description</label>
    <textarea class="form-control" name="content" id="content" cols="30" rows="5">{{ old('content', isset($poll->content) ? $poll->content : null) }}</textarea>
</div>
<div class="form-group">
    <label for="expires_at">Expires at</label>
    <input type="date" class="form-control" name="expires_at" id="expires_at" value="{{ old('title', isset($poll->expires_at) ? date('Y-m-d', strtotime($poll->expires_at)) : null) }}">
</div>
<label for="photo">Photo</label>
<div>
    <input type="file" name="image" id="photo">
</div>

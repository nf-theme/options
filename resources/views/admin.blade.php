<div id="nf-theme-option">
	@if($should_flash)
		<div class="alert alert-success" role="alert">
		  <strong>Well done!</strong> Options are saved successfully.
		</div>
	@endif
    <div class="nto-header">
        <h4 class="nto-title bd-title">Theme Configuration</h4>
        <ul class="nto-tabs nav nav-tabs">
            @foreach($pages as $page)
            <li class="nto-item nav-item">
                <a class="{{ $manager->isPage($page->name) ? 'nto-menu-link-link nav-link active' : 'nto-menu-link-link nav-link' }}" href="{{$manager->getTabUrl($page->name)}}">{{$page->name}}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="nto-content">
        <div class="nto-form">
            <form method="POST" name="nto_form" action="{{admin_url('admin-post.php')}}">
            	<input type="hidden" value="nto_save" name="action" required>
            	<input type="hidden" value="{{$current_page->name}}" name="page" required>
                @foreach($current_page->fields as $field)
                {!! $field->render() !!}
                @endforeach
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save">
                    <button name="nto_cancel" class="btn btn-secondary" onclick="document.location.reload(); return false;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

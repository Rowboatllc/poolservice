<div class="row option_panel" data-group="global" data-saveurl="{{ route('save-option') }}" data-removeurl="{{ route('remove-option') }}" >
    <div class="an_option" data-key=""  >
            {{ csrf_field() }}
            <input type="input" name="option_label" placeholder="label" value="" />
            <input type="input" name="option_key" placeholder="name" value=""  />
            <input type="input" name="option_value" placeholder="value" value="" />
            <span class="glyphicon glyphicon-remove remove_option"></span>
            <span class="glyphicon glyphicon-ok save_option"></span>
        </div>
    
    @foreach ($options as $option)
        <div class="an_option" data-key="{{ $option->key }}">
            {{ csrf_field() }}
            <input type="input" name="option_label" placeholder="label" value="{{ $option->label }}" />
            <input type="input" name="option_key" placeholder="name" value="{{ $option->mykey }}" disabled="disabled" />
            <input type="input" name="option_value" placeholder="value" value="{{ $option->value }}" />
            <span class="glyphicon glyphicon-remove remove_option"></span>
            <span class="glyphicon glyphicon-ok save_option"></span>
        </div>
    @endforeach
    <div>
        <span class="glyphicon glyphicon-plus add_new"></span>
    </div>
</div>
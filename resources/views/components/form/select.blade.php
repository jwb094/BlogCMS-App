@props([
'formdata',
'fieldname',
'recordFieldData' => null,
'categories'])
<select {{ $attributes->merge(['class' => '','aria-label'=>'']) }}>

    <option selected value="0">Select a Category</option>
    @foreach($categories as $key => $value)
    <option value="{{ $value->id }}" @selected(old($fieldname,($recordFieldData === $value->id)))>{{ $value->title}}</option>
    @endforeach
</select>

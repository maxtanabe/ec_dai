<form action="/submit" method="post">
    <select name="delivery_date">
        @foreach($options as $option)
            <option value="{{$option['date']}}">{{$option["formatted_date"]}}</option>
        @endforeach
    </select>
    <button type="submit">注文</button>
</form>

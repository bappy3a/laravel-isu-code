if (isset($request->date_filter)) {
    $parts = explode(' - ' , $request->date_filter);
    $date_from = Carbon::parse($parts[0])->format('Y-m-d');
    $date_to = Carbon::parse($parts[1])->format('Y-m-d');
    $expenses = Expenses::whereBetween('created_at', [$date_from, $date_to])->get();
}

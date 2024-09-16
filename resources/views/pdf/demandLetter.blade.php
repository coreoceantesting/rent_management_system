<!-- resources/views/pdf/demand_letter.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Demand Letter</title>
    <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
          text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center">Demand Letter</h1>
    <table style="width:100%">
        <tr>
          <th>Scheme Name</th>
          <th>Scheme Proposal Number</th> 
          <th>Developer Name</th>
          <th>Demand Amount</th>
        </tr>
        <tr>
          <td>{{ $list->scheme_name }}</td>
          <td>{{ $list->scheme_proposal_number }}</td>
          <td>{{ $list->developer_name }}</td>
          <td>{{ $list->demand_amount }}</td>
        </tr>
      </table>
</body>
</html>

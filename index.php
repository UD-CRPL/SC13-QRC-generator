<html>

<head>
    <title>Batch QR Code Generator</title>

    <style>
        body{
            text-align: center;
            font-family: Arial,sans-serif;
        }
        textarea{
            width: 600px;
            height: 400px;
        }
        
        img{
            height: 400px;
        }
    </style>

</head>


<body>

    <h1>Batch QR Code Generator</h1>
    <p>The below form takes 5 pipe ( | ) separated values per line as defined by the below image. The URL will automatically be shortened via bit.ly. Please use Chrome or Safari for the best results when printing.</p>
    
    <img src="./example.png">
    
    <p>So the input that generated the image above was: <br> "SC13 Technical Program - Poster|http://example.com/|#1|ACM|Speedup and Numerical Evaluation of Multiple-Precision Krylov Subspace Method Using GPU Cluster for Large-Sparse Linear System"</p>

    <form action="action.php" method="POST">
    
    <textarea name="input"></textarea>
    
    <br><br>
    
    <input type="submit">
    </form>


</body>
</html>
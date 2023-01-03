<?php
    $pdfText = '';

    if(isset($_POST['submit'])){ 
        // If file is selected 
        if(!empty($_FILES["pdf_file"]["name"])){ 
            // File upload path 
            $fileName = basename($_FILES["pdf_file"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('pdf'); 
            if(in_array($fileType, $allowTypes)){ 
                // Include autoloader file 
                include 'vendor/autoload.php'; 
                
                // Initialize and load PDF Parser library 
                $parser = new \Smalot\PdfParser\Parser(); 
                
                // Source PDF file to extract text 
                $file = $_FILES["pdf_file"]["tmp_name"]; 
                
                // Parse pdf file using Parser library 
                $pdf = $parser->parseFile($file); 
                
                // Extract text from PDF 
                $text = $pdf->getText(); 
                
                // Add line break 
                $pdfText = nl2br($text); 
            }else{ 
                $statusMsg = '<p>Sorry, only PDF file is allowed to upload.</p>'; 
            } 
        }else{ 
            $statusMsg = '<p>Please select a PDF file to extract text.</p>'; 
        } 
} 
 
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Text to PDF </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <h2> Extract Text to PDF </h2> <br>
            <div class="cw=frm">
                <!-- Status Message -->
            <?php if(!empty($statusMsg)){ ?>
                <div class="status-msg <?php echo $status; ?>"> <?php echo $statusMsg; ?> </div>
                <?php } ?>
                

                <!-- File Upload Form -->
            <form action="submit.php" method="post" enctype="multipart/form-data">
                <div class="form-input">
                    <label for="pdf_file">PDF File</label>
                    <input type="file" name="pdf_file" placeholder="Select a PDF file" required="">
                </div> <br> 
                <input type="submit" name="submit" class="btn btn-primary" value="Extract Text"><br>
            </form>
    </div>
  </div>

<div class="wrapper-res"> <br>
    <!-- Display text extracted from uploaded PDF -->
  <?php if(!empty($pdfText)){ ?>
    <div class="frm-result">
        <p><?php echo $pdfText; ?></p>
    </div>
    <?php } ?>
</div>

<div class="footer"> <br>
    <p>
        &copy; 2021 Hashira
    </p>
    </div>
 </div>

</body>
</html>

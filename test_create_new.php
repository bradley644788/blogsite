<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
<div id="root"></div>
</body>
<textarea name="paragraph" id="paragraph"></textarea>
<button type="submit" id="button">submit</button>
    <script>
        function newElement(target){
            // root = document.getElementById(target);
            // root.innerHTML = "This is a test";
            // newDiv = document.createElement("textarea");
            // newDiv.value = "This is some test text";
            // root.appendChild(newDiv);
        }
        newElement("root");
    </script>
</html>
<?php
// Definir variables y establecer valores vacíos
$name = $age = $email = $course = $gender = "";
$interest = "";
$nameErr = $ageErr = $emailErr = $courseErr = $genderErr = $interestErr = "";

// Opciones de cursos basadas en el área de interés
$courses = [
    "Tecnología" => ["Diseño web", "Diseño gráfico", "Diseño móvil"],
    "Ciencia" => ["Primeros auxilios", "Cuidado al adulto mayor", "Biología básica"],
    "Gastronomía" => ["Cocina típica", "Manipulación de alimentos", "Pastelería"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar nombre
    if (empty($_POST["name"])) {
        $nameErr = "El nombre es obligatorio";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validar edad
    if (empty($_POST["age"])) {
        $ageErr = "La edad es obligatoria";
    } else {
        $age = test_input($_POST["age"]);
        // Verificar si la edad es un número
        if (!is_numeric($age)) {
            $ageErr = "La edad debe ser un número";
        } else {
            // Verificar si la edad es menor de 18
            if ($age < 18) {
                $ageErr = "Debes de ser mayor de edad";
            }
        }
    }

    // Validar correo electrónico
    if (empty($_POST["email"])) {
        $emailErr = "El correo electrónico es obligatorio";
    } else {
        $email = test_input($_POST["email"]);
        // Verificar formato de correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato de correo electrónico inválido";
        }
    }

    // Validar área de interés
    if (empty($_POST["interest"])) {
        $interestErr = "Debes seleccionar un área de interés";
    } else {
        $interest = test_input($_POST["interest"]);
    }

    // Validar curso seleccionado
    if (empty($_POST["course"])) {
        $courseErr = "Debes seleccionar un curso";
    } else {
        $course = test_input($_POST["course"]);
    }

    // Validar género
    if (empty($_POST["gender"])) {
        $genderErr = "Debes seleccionar un género";
    } else {
        $gender = test_input($_POST["gender"]);
    }
}

// Función para limpiar los datos recibidos
function test_input($data) {
    $data = trim($data);  // Elimina espacios extra al principio y final
    $data = stripslashes($data);  // Elimina barras invertidas
    $data = htmlspecialchars($data);  // Convierte caracteres especiales en entidades HTML
    return $data;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function updateCourses() {
            var area = document.getElementById("interest").value;
            var courses = {
                "Tecnología": ["Diseño web", "Diseño gráfico", "Diseño móvil"],
                "Ciencia": ["Primeros auxilios", "Cuidado al adulto mayor", "Biología básica"],
                "Gastronomía": ["Cocina típica", "Manipulación de alimentos", "Pastelería"]
            };
            var courseSelect = document.getElementById("course");
            courseSelect.innerHTML = "<option value=''>Selecciona un curso</option>";

            if (area && courses[area]) {
                courses[area].forEach(function(course) {
                    var option = document.createElement("option");
                    option.value = course;
                    option.textContent = course;
                    courseSelect.appendChild(option);
                });
            }
        }

        function scrollToResults() {
            document.getElementById("results").scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center">Formulario de Registro</h2>
        <form method="post" action="" class="mt-4">
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td><strong>Nombre:</strong></td>
                        <td><input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" required></td>
                    </tr>
                    <tr>
                        <td><strong>Edad:</strong></td>
                        <td>
                            <input type="text" id="age" name="age" class="form-control" value="<?php echo $age; ?>" required>
                            <?php if (!empty($ageErr)) echo "<div class='text-danger'>$ageErr</div>"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Género:</strong></td>
                        <td>
                            <div class="form-check">
                                <input type="radio" id="femenino" name="gender" value="Femenino" class="form-check-input" <?php if ($gender == "Femenino") echo "checked"; ?> required>
                                <label class="form-check-label" for="femenino">Femenino</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="masculino" name="gender" value="Masculino" class="form-check-input" <?php if ($gender == "Masculino") echo "checked"; ?> required>
                                <label class="form-check-label" for="masculino">Masculino</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="otro" name="gender" value="Otro" class="form-check-input" <?php if ($gender == "Otro") echo "checked"; ?> required>
                                <label class="form-check-label" for="otro">Otro</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Correo electrónico:</strong></td>
                        <td>
                            <input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                            <?php if (!empty($emailErr)) echo "<div class='text-danger'>$emailErr</div>"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Área de interés:</strong></td>
                        <td>
                            <select id="interest" name="interest" class="form-select" onchange="updateCourses()" required>
                                <option value="">Selecciona un área de interés</option>
                                <option value="Tecnología" <?php if ($interest == "Tecnología") echo "selected"; ?>>Tecnología</option>
                                <option value="Ciencia" <?php if ($interest == "Ciencia") echo "selected"; ?>>Ciencia</option>
                                <option value="Gastronomía" <?php if ($interest == "Gastronomía") echo "selected"; ?>>Gastronomía</option>
                            </select>
                            <?php if (!empty($interestErr)) echo "<div class='text-danger'>$interestErr</div>"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Curso:</strong></td>
                        <td>
                            <select id="course" name="course" class="form-select" required>
                                <option value="">Selecciona un curso</option>
                                <?php
                                if ($interest && isset($courses[$interest])) {
                                    foreach ($courses[$interest] as $courseOption) {
                                        $selected = ($course == $courseOption) ? "selected" : "";
                                        echo "<option value='$courseOption' $selected>$courseOption</option>";
                                    }
                                }
                                ?>
                            </select>
                            <?php if (!empty($courseErr)) echo "<div class='text-danger'>$courseErr</div>"; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary mt-3">Enviar</button>
            <button type="button" class="btn btn-secondary mt-3" onclick="scrollToResults()">Mostrar resultados</button>
        </form>
    </div>

    <div class="container mt-5" id="results">
        <?php
        // Mostrar los datos si el formulario ha sido enviado y es válido
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $nameErr == "" && $ageErr == "" && $emailErr == "" && $courseErr == "" && $genderErr == "" && $interestErr == "") {
            echo "<h3 class='text-center'>Información recibida:</h3>";
            echo "<table class='table table-bordered table-sm mt-3'>";
            echo "<thead class='table-light'>";
            echo "<tr>";
            echo "<th>Campo</th>";
            echo "<th>Valor</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            echo "<tr><td><strong>Nombre:</strong></td><td>" . htmlspecialchars($name) . "</td></tr>";
            echo "<tr><td><strong>Edad:</strong></td><td>" . htmlspecialchars($age) . "</td></tr>";
            echo "<tr><td><strong>Correo electrónico:</strong></td><td>" . htmlspecialchars($email) . "</td></tr>";
            echo "<tr><td><strong>Área de interés:</strong></td><td>" . htmlspecialchars($interest) . "</td></tr>";
            echo "<tr><td><strong>Curso seleccionado:</strong></td><td>" . htmlspecialchars($course) . "</td></tr>";
            echo "<tr><td><strong>Género al nacer:</strong></td><td>" . htmlspecialchars($gender) . "</td></tr>";
            echo "</tbody>";
            echo "</table>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

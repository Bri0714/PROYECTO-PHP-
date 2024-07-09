<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        padding: 70px;
    }

    .box {
        max-width: 500px;
        width: 100%;
    }
</style>
</head>

<body>
    <div class="container">
        <div class="box has-text-centered">
            <div id="startContainer">
                <h3 class="title is-3">RACE (Evaluación de emergencias médicas)</h3>
                <p class="subtitle is-5 p-6">La evaluación RACE se utiliza para determinar la prioridad de tratamiento en emergencias médicas.</p>
                <button id="startButton" class="button has-background-danger-dark has-text-light">Comenzar Evaluación</button>
            </div>
            <div id="questionContainer" style="display: none;">
                <form id="triageForm" method="post" action="index.php?vista=calificacion">
                    <div id="questionBox"></div>
                    <div class="field is-grouped is-justify-content-center mt-4">
                        <div class="control">
                            <button id="prevButton" class="button has-background-danger-dark has-text-light" disabled>Anterior</button>
                        </div>
                        <div class="control">
                            <button id="nextButton" class="button has-background-danger-dark has-text-light">Siguiente</button>
                        </div>
                    </div>
                    <input type="hidden" id="answersInput" name="answers" value="">
                </form>
            </div>
            <div id="evaluationButton" class="field is-grouped mt-4" style="display: none;">
                <div class="control">
                    <p class="subtitle is-5 p-6"> <?php echo 'Gracias por tus respuestas' . " " . $_SESSION["nombre"] ?></p>
                    <button id="submitButton" class="button has-background-danger-dark has-text-light">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        const questions = [{
                question: "¿El paciente presenta debilidad facial en un lado del rostro?",
                options: [{
                        label: "Sí",
                        value: "si"
                    },
                    {
                        label: "No",
                        value: "no"
                    }
                ],
                name: "debilidad_facial",
                specification: "Pida al paciente que sonría. ¿Un lado de la cara se cae?"
            },
            {
                question: "¿El paciente tiene dificultad para levantar ambos brazos?",
                options: [{
                        label: "Sí",
                        value: "si"
                    },
                    {
                        label: "No",
                        value: "no"
                    }
                ],
                name: "dificultad_brazos",
                specification: "Pida al paciente que levante ambos brazos. ¿Uno de los brazos cae hacia abajo?"
            },
            {
                question: "¿El paciente muestra dificultad para hablar o expresarse?",
                options: [{
                        label: "Sí",
                        value: "si"
                    },
                    {
                        label: "No",
                        value: "no"
                    }
                ],
                name: "dificultad_habla",
                specification: "Pida al paciente que repita una frase simple. ¿Las palabras están arrastradas o incompletas?"
            },
            {
                question: "¿Cuánto tiempo ha transcurrido desde que comenzaron los síntomas?",
                options: [{
                        label: "Menos de 3 horas",
                        value: "menos_3_horas"
                    },
                    {
                        label: "Entre 3 y 6 horas",
                        value: "entre_3_6_horas"
                    },
                    {
                        label: "Más de 6 horas",
                        value: "mas_6_horas"
                    },
                    {
                        label: "No está claro / Desconocido",
                        value: "desconocido"
                    }
                ],
                name: "tiempo_sintomas",
                specification: "Trate de obtener la mayor precisión posible sobre el inicio de los síntomas."
            },
            {
                question: "¿Cuál es la frecuencia respiratoria del paciente?",
                options: [{
                        label: "Normal (12-20 respiraciones por minuto)",
                        value: "normal"
                    },
                    {
                        label: "Elevada (>20 respiraciones por minuto)",
                        value: "elevada"
                    },
                    {
                        label: "Baja (<12 respiraciones por minuto)",
                        value: "baja"
                    }
                ],
                name: "freq_respiratoria",
                specification: "Cuente las respiraciones del paciente durante un minuto completo."
            },
            {
                question: "¿El paciente está alerta y orientado?",
                options: [{
                        label: "Sí",
                        value: "si"
                    },
                    {
                        label: "Parcialmente",
                        value: "parcial"
                    },
                    {
                        label: "No",
                        value: "no"
                    }
                ],
                name: "alerta_orientado",
                specification: "Pregunte al paciente su nombre, ubicación y fecha para evaluar la orientación."
            },
            {
                question: "¿Hay signos de circulación deficiente?",
                options: [{
                        label: "Sí",
                        value: "si"
                    },
                    {
                        label: "No",
                        value: "no"
                    }
                ],
                name: "circulacion_deficiente",
                specification: "Busque signos como piel fría, pálida o sudoración excesiva."
            },
            {
                question: "¿El paciente presenta algún problema de exposición?",
                options: [{
                        label: "Sí",
                        value: "si"
                    },
                    {
                        label: "No",
                        value: "no"
                    },
                    {
                        label: "No se ha evaluado",
                        value: "no_evaluado"
                    }
                ],
                name: "problema_exposicion",
                specification: "Revise si hay lesiones visibles, sangrado o quemaduras."
            }
        ];
        let currentIndex = 0;
        let answers = {};

        function renderQuestion(index) {
            const question = questions[index];
            const questionBox = document.getElementById("questionBox");
            questionBox.innerHTML = `
                <h3 class="title is-4">${question.question}</h3>
                <p>${question.specification}</p>
                <div class="control">
                    ${question.options.map(option => `
                        <label class="radio">
                            <input type="radio" name="${question.name}" value="${option.value}" required>
                            ${option.label}
                        </label>
                    `).join("")}
                </div>
            `;

            const prevButton = document.getElementById("prevButton");
            const nextButton = document.getElementById("nextButton");

            prevButton.disabled = index === 0;
            nextButton.disabled = false;

            if (index === questions.length - 1) {
                nextButton.textContent = "Enviar";
            } else {
                nextButton.textContent = "Siguiente";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("startButton").addEventListener("click", function() {
                document.getElementById("startContainer").style.display = "none";
                document.getElementById("questionContainer").style.display = "block";
                renderQuestion(currentIndex);
            });

            document.getElementById("prevButton").addEventListener("click", function() {
                currentIndex--;
                renderQuestion(currentIndex);
            });

            document.getElementById("nextButton").addEventListener("click", function() {
                const questionName = questions[currentIndex].name;
                const selectedOption = document.querySelector(`input[name="${questionName}"]:checked`);

                if (selectedOption) {
                    answers[questionName] = selectedOption.value;
                    currentIndex++;

                    if (currentIndex === questions.length) {
                        document.getElementById("questionContainer").style.display = "none";
                        document.getElementById("evaluationButton").style.display = "block";
                        document.getElementById("answersInput").value = JSON.stringify(answers);
                    } else {
                        renderQuestion(currentIndex);
                    }
                } else {
                    alert("Por favor, seleccione una opción antes de continuar.");
                }
            });

            document.getElementById("submitButton").addEventListener("click", function() {
                // Enviar el formulario
                document.getElementById("triageForm").submit();
            });
        });
    </script>
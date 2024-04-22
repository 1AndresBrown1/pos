<!-- Agrega este código al final del body de tu HTML -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Mi asistente</h5>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes colocar el contenido de tu chat -->
                <?php
                $api_chatgpt = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';
                $mensaje = 'dime tips para programadores';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $api_chatgpt,
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     \"model\": \"gpt-3.5-turbo\",\n     \"messages\": [{\"role\": \"user\", \"content\": \"$mensaje\"}],\n     \"temperature\": 0.7\n   }");

                $response = curl_exec($ch);
                curl_close($ch);

                $respuesta = json_decode($response);
                $mensaje_respuesta = $respuesta->choices[0]->message->content;

                echo '<h5> Consejo dinámico: ' . $mensaje . '</h5>';
                echo '<h5> Respuesta dinámica: </h5>';
                echo '<p>' . $mensaje_respuesta . '</p>';
                ?>
            </div>
        </div>
    </div>
</div>

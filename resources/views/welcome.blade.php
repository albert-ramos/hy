<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Rover Mars</title>
    </head>
    <body class="antialiased">

        <div>
            <h2>Reset session</h2>
            <form action="{{ route('api:10:reset') }}" id="reset-form">
                <button type="submit">Reset</button>
            </form>

            <div>Output:</div>
            <div id="reset-response" class="responses"></div>
        </div>

        <div>
            <h2>Start</h2>
            <form action="{{ route('api:10:init') }}" id="start-form">
                <div>
                    <label for="starting-point">Starting point</label>
                    <input type="text" id="starting-point" placeholder="x,y">
                </div>
    
                <div>
                    <label for="direction">Direction</label>
                    <select name="direction" id="direction">
                        <option value="n">North</option>
                        <option value="e">East</option>
                        <option value="s">South</option>
                        <option value="w">West</option>
                    </select>
                </div>

                <button type="submit">Start</button>
            </form>

            <div>Output:</div>
            <div id="start-response" class="responses"></div>
        </div>
        
        <div>
            <h2>Commands</h2>
            <form action="{{ route('api:10:command') }}" id="command-form">
                <div>
                    <label for="commands">Commands</label>
                    <input type="text" id="commands-input">
                </div>

                <button type="submit">Drive</button>
            </form>

            <div>Output:</div>
            <div id="command-response" class="responses"></div>
        </div>

        <script>            
            (function() {
                async function postData(url = '', data = {}) {
                    const response = await fetch(url, {
                        method: 'POST',
                        mode: 'cors',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector("[name='csrf-token']").content
                        },
                        redirect: 'follow',
                        referrerPolicy: 'no-referrer',
                        body: JSON.stringify(data)
                    });
                    return response.json();
                }

                let resetForm = document.querySelector('#reset-form');
                resetForm.onsubmit = onResetSubmit;
                function onResetSubmit(e) {
                    e.preventDefault();
                    resetResponses();

                    let url = resetForm.getAttribute('action');

                    postData(url, {}).then(responseData => {
                        let resetResponse = document.querySelector('#reset-response');
                        writeResponse(resetResponse, responseData.data.output);
                    });
                }

                function resetResponses() {
                    let responses = document.querySelectorAll('.responses');
                    responses.forEach(el => {
                        el.innerHTML = '';
                    });
                }

                let startForm = document.querySelector('#start-form');
                startForm.onsubmit = onStartSubmit;
                function onStartSubmit(e) {
                    e.preventDefault();
                    
                    let startingInput = document.querySelector('#starting-point');
                    let directionSelect = document.querySelector('#direction');
                    let url = startForm.getAttribute('action');
                    let coordSplitted = startingInput.value.split(',');
                    
                    let coordinates = {
                        x: coordSplitted[0],
                        y: coordSplitted[1]
                    }
                    postData(url, { 
                        coordinates: coordinates,
                        direction: directionSelect.value
                    }).then(responseData => {
                        let startResponse = document.querySelector('#start-response');
                        let x = responseData.data.x;
                        let y = responseData.data.y;
                        let direction = responseData.data.direction;
                        let startMessage = `Coordinates setted to x: ${x} y: ${y} and direction: ${direction}`;
                        writeResponse(startResponse, startMessage);
                    });
                }

                let commandForm = document.querySelector('#command-form');
                commandForm.onsubmit = onCommandSubmit;
                function onCommandSubmit(e) {
                    e.preventDefault();
                    let commandsInput = document.querySelector('#commands-input');
                    let url = commandForm.getAttribute('action');

                    postData(url, { 
                        commands: commandsInput.value
                    }).then(responseData => {
                        let commandResponse = document.querySelector('#command-response');
                        writeResponse(commandResponse, responseData.data.output);
                    });
                }

                function writeResponse(el, msg) {
                    el.innerText = msg;
                }
            })(document)
        </script>
    </body>
</html>

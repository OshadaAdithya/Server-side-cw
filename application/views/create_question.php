<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Question</title>
    <!--<link rel="stylesheet" href="">-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <style>
        body{
            background-color: #E6E6FA;

        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #DCDCDC;

        }

        input[type="text"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        textarea{
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            margin-bottom: 15px;
            font-family: Arial, Helvetica, sans-serif;

        }

		label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 1.2em; /* Increase the font size of the labels */

        }

        button {
			background-color: #007bff;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			font-size: 1em;
		}

		button:hover {
			background-color: #0056b3;
		}

        h2{
            color: #8B0000;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Ask a Question</h2>
        <form id="questionForm">
            <label>Title:</label>
            <input type="text" id="title" required>
            <label>Body:</label>
            <textarea id="body" required></textarea>
            <br>
            <button type="submit">Post</button>
        </form>
    </div>
    <script>
        

        // Define the Question model
        var Question = Backbone.Model.extend({
            urlRoot: '<?php echo site_url('question/postQuestion'); ?>',
            defaults: {
                title: '',
                body: ''
            }
        });

        // Define the Question view
        var QuestionView = Backbone.View.extend({
            el: '#questionForm',
            events: {
                'submit': 'submitForm'
            },
            submitForm: function(event) {
                event.preventDefault();
                var question = new Question({
                    title: this.$('#title').val(),
                    body: this.$('#body').val()
                });
                question.save(null, {
                    success: function(model, response) {
                        console.log(response);
                        if (response.status === 'success') {
                            window.location.href = '<?php echo site_url('questions'); ?>';
                        } else {
                            alert('Failed to post question');
                        }
                    }
                });
            }
        });

        // Initialize the Question view
        $(document).ready(function() {
            new QuestionView();
        });
    </script>
</body>
</html>

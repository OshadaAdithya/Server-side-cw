<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Questions</title>
    <!--<link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css'); ?>">-->
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
        .custom-btn {
            padding: 15px 20px;
            background-color: #28a745; /* Change this color to your desired button color */
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 15px; /* Increase font size */
            border-radius: 5px; /* Optional: add rounded corners */
        }
        .custom-btn:hover {
            background-color: #218838; /* Darker shade for hover effect */
        }

        h2{
            color: #800000;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 30px;
        }

        .question-title {
            font-size: 22px; /* Adjust the font size as needed */
        }

        .question-body {
            font-size: 18px; /* Adjust the font size as needed */
        }

        
    </style>
    <script>
        // Define the Question model
        var Question = Backbone.Model.extend({
            defaults: {
                title: '',
                body: ''
            }
        });

        // Define the Question Collection
        var QuestionCollection = Backbone.Collection.extend({
            model: Question,
            url: '<?php echo site_url('question/getQuestions'); ?>',
            parse: function(response) {
                return response.questions;
            }
        });

        // Define the Question View
        var QuestionView = Backbone.View.extend({
            tagName: 'div',
            className: 'question-item',
            //template: _.template('<h3><%= title %></h3><p><%= body %></p>'),
            //template: _.template('<h3><a href="<?php echo site_url('question/view'); ?>/<%= id %>"><%= title %></a></h3><p><%= body %></p>'),
            template: _.template('<h3 class="question-title"><a href="<?php echo site_url('question/view'); ?>/<%= id %>"><%= title %></a></h3><p class="question-body"><%= body %></p>'),

            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
        });

        // Define the Questions List View
        var QuestionsListView = Backbone.View.extend({
            el: '#questionsList',
            initialize: function() {
                this.collection = new QuestionCollection();
                this.listenTo(this.collection, 'sync', this.render);
                this.collection.fetch({
                    success: function(collection, response, options) {
                        console.log(response);
                    },
                    error: function(collection, response, options) {
                        console.error('Failed to fetch questions');
                    }
                });
            },
            render: function() {
                this.$el.empty();
                this.collection.each(this.addOne, this);
                return this;
            },
            addOne: function(question) {
                var questionView = new QuestionView({ model: question });
                this.$el.append(questionView.render().el);
            }
        });

        // Initialize the Questions List View
        $(document).ready(function() {
            new QuestionsListView();
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Questions</h2>
        <!--<a href="<?php echo site_url('questions/create'); ?>" class="btn btn-primary">Create Question</a>-->
        <button onclick="window.location.href='<?php echo site_url('questions/create'); ?>'" class="custom-btn">Add Question</button>

        <div id="questionsList"></div>
        
    </div>
</body>
</html>


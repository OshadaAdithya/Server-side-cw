<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
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
        .question-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .question-item button {
            padding: 5px 10px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }

        .question-link {
            font-size: 20px;
            text-decoration: underline;
            cursor: pointer;
            color: blue; /* Optionally, you can change the color to blue to indicate a link */
        }

        h1{
            color: #800000;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 40px;

        }

        #text2{
            color: #800080;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Your Profile</h1>
        <!--<h2>Welcome, <?php echo $user['username']; ?> (<?php echo $user['email']; ?>)</h2>-->

        <h2 id="userDetails"></h2>
        <h2 id="text2">Your Questions</h2>
        <div id="questionsList"></div>
    </div>
    <script>
        
        // User Model
        var User = Backbone.Model.extend({
            url: '<?php echo site_url('user/showDetail'); ?>',
            parse: function(response) {
                return response.details.user;
            }
        });

        // User View
        var UserView = Backbone.View.extend({
            el: '#userDetails',
            initialize: function() {
                this.model = new User();
                this.listenTo(this.model, 'sync', this.render);
                this.model.fetch();
            },
            render: function() {
                var user = this.model.toJSON();
                this.$el.html('Welcome, ' + user.username + ' (' + user.email + ')');
                return this;
            }
        });

        var Question = Backbone.Model.extend({
            urlRoot: '<?php echo site_url('question'); ?>',
            url: function() {
                return this.urlRoot + '/delete/' + this.id;
            }
        });

        var QuestionCollection = Backbone.Collection.extend({
            model: Question,
            url: '<?php echo site_url('question/getUserQuestions'); ?>',
            parse: function(response) {
                return response.questions;
            }
        });

        var QuestionView = Backbone.View.extend({
            tagName: 'div',
            className: 'question-item',
            template: _.template('<a class="question-link"><%= title %></a> <button class="delete-button">Delete</button>'),
            events: {
                'click .question-link': 'viewQuestion',
                'click .delete-button': 'deleteQuestion'
            },
            initialize: function() {
                this.listenTo(this.model, 'destroy', this.remove);
            },
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            
            viewQuestion: function() {
                window.location.href = '<?php echo site_url('question/view/'); ?>' + this.model.id;
            },

            deleteQuestion: function() {
                // if (confirm('Are you sure you want to delete this question?')) {
                //     this.model.destroy();
                // }

                if (confirm('Are you sure you want to delete this question?')) {
                    var that = this;
                    this.model.destroy({
                        success: function(model, response) {
                            alert('Question deleted successfully');
                            that.remove();
                        },
                        error: function(model, response) {
                            alert('Failed to delete question');
                        }
                    });
                }
            }
        });

        var QuestionListView = Backbone.View.extend({
            el: '#questionsList',
            initialize: function() {
                this.collection = new QuestionCollection();
                this.listenTo(this.collection, 'sync', this.render);
                this.collection.fetch();
            },
            render: function() {
                this.$el.empty();
                this.collection.each(function(question) {
                    var view = new QuestionView({ model: question });
                    this.$el.append(view.render().el);
                }, this);
                return this;
            }
        });

        $(document).ready(function() {
            new UserView();
            new QuestionListView();
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question Detail</title>
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

        textarea{
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            margin-bottom: 15px;
            font-family: Arial, Helvetica, sans-serif;

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

        #questionTitle{
            color: #333;
            font-size: 24px;

        }

        #questionBody{
            color: #333;
            font-size: 18px;
        }

        #answersList{
            color: #333;
            font-size: 18px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Question:</h2>
        <h2 id="questionTitle"></h2>
        <p id="questionBody"></p>
        <br>
        <h2>Answers:</h2>
        <div id="answersList"></div>
        <br>
        <?php if ($this->session->userdata('user_id')): ?>
            <form id="answerForm">
                <textarea id="answerText" placeholder="Your answer"></textarea>
                <button type="submit">Post Answer</button>
            </form>
        <?php else: ?>
            <p><a href="<?php echo site_url('user/login'); ?>">Login to post an answer</a></p>
        <?php endif; ?>
    </div>
    <script>
        var isLoggedIn = <?php echo json_encode($this->session->userdata('user_id') !== null); ?>;
        var currentUserId = <?php echo json_encode($this->session->userdata('user_id')); ?>;
        var questionId = <?php echo $question_id; ?>;

        var Question = Backbone.Model.extend({
            urlRoot: '<?php echo site_url('question/getQuestion'); ?>',
            defaults: {
                title: '',
                body: ''
            }
        });

        var Answer = Backbone.Model.extend({
            urlRoot: '<?php echo site_url('answer/postAnswer'); ?>',
            defaults: {
                body: '',
                question_id: '',
                user_id: '',
                is_best: 0,
                upvotes: 0,
                downvotes: 0
            }
        });

        var AnswerCollection = Backbone.Collection.extend({
            model: Answer,
            url: '<?php echo site_url('answer/getAnswers'); ?>/' + questionId,
            parse: function(response) {
                return response.answers;
            }
        });

        var AnswerView = Backbone.View.extend({
            tagName: 'div',
            className: 'answer-item',
            template: _.template(`
                <p><%= body %></p>
                
            `),
            events: {
                'click .upvote': 'upvote',
                'click .downvote': 'downvote'
            },
            initialize: function() {
                this.listenTo(this.model, 'change', this.render);
            },
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            // upvote: function() {
            //     this.vote('upvote');
            // },
            // downvote: function() {
            //     this.vote('downvote');
            // },
            // vote: function(type) {
            //     var self = this;
            //     $.ajax({
            //         url: '<?php echo site_url('answer/vote'); ?>',
            //         type: 'POST',
            //         data: JSON.stringify({
            //             answer_id: this.model.get('id'),
            //             vote_type: type
            //         }),
            //         contentType: 'application/json',
                    
            //         success: function(response) {
                        
            //             if (response.status === 'success') {
            //                 console.log(response);
            //                 if (type === 'upvote') {
            //                     self.model.set('upvotes', self.model.get('upvotes') + 1);
            //                 } else {
            //                     self.model.set('downvotes', self.model.get('downvotes') + 1);
            //                 }
            //                 self.render();  // Re-render the view to update the vote count
            //             } else {
            //                 console.log(response.message || 'Error voting');
            //             }
            //         },
            //         error: function(response) {
            //             console.error('Failed to vote', response);
            //             alert('Error voting');
            //         }
            //     });
            // }
        });

        var QuestionDetailView = Backbone.View.extend({
            el: '.container',
            initialize: function() {
                this.answers = new AnswerCollection();
                this.listenTo(this.answers, 'sync', this.renderAnswers);
                this.answers.fetch({
                    error: function(collection, response) {
                        console.error('Failed to fetch answers', response);
                    }
                });

                this.$el.off('submit', '#answerForm');  // Ensure no duplicate handlers
                this.$el.on('submit', '#answerForm', this.submitAnswer.bind(this));
            },
            renderAnswers: function() {
                var answersDiv = this.$('#answersList');
                answersDiv.empty();
                this.answers.each(function(answer) {
                    var answerView = new AnswerView({ model: answer });
                    answersDiv.append(answerView.render().el);
                });
            },
            submitAnswer: function(e) {
                e.preventDefault();
                if (!isLoggedIn) {
                    alert('Please log in to post an answer.');
                    var redirectUrl = encodeURIComponent(window.location.href + '#answerForm');
                    window.location.href = '<?php echo site_url('user/login?redirect='); ?>' + redirectUrl;
                    return;
                }

                var answerText = this.$('#answerText').val();
                if (!answerText.trim()) {return;} // Prevent empty submissions

                var answer = new Answer({
                    body: answerText,
                    question_id: questionId,
                    user_id: currentUserId
                });

                var self = this;
                var submitButton = this.$('#answerForm button[type="submit"]');
                submitButton.prop('disabled', true); // Disable the submit button
                answer.save(null, {
                    success: function(model, response) {
                        self.answers.fetch();
                        self.$('#answerText').val(''); // Clear the textarea
                        submitButton.prop('disabled', false); // Re-enable the submit button
                    },
                    error: function(model, response) {
                        console.error('Failed to save answer', response);
                        submitButton.prop('disabled', false); // Re-enable the submit button
                    }
                });
            }
        });

        var question = new Question({ id: questionId });
        question.fetch({
            success: function(model) {
                $('#questionTitle').text(model.get('title'));
                $('#questionBody').text(model.get('body'));
            },
            error: function(model, response) {
                console.error('Failed to fetch question', response);
            }
        });

        $(document).ready(function() {
            new QuestionDetailView();
        });
    </script>
</body>
</html>

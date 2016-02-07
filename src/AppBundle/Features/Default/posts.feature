Feature:
  Ensures that all post titles are shown

  Scenario: The table header is shown
    When I am on "/posts"
    Then the response status code should be 200
    And I should see "PostID"
    And I should see "Title"

  Scenario: All post titles are shown from datafixtures
    When I am on "/posts"
    Then the response status code should be 200
    And I should see "Post title 1"
    And I should see "Post title 2"
    And I should not see "Post title 3"

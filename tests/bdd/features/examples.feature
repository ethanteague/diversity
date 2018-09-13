@example
Feature: Page Loading
  In order to verify basic application functionality, load page and 
  check status code as anonymous and authenticated users.

  Scenario: Load front page and check status
    Given I am on "/"
    Then the response status code should be 200

   @api
   Scenario: Load page as authenticated user
     Given I am logged in as a user with the "authenticated" role
     And I am on "/"
     Then the response status code should be 200

  @api
   Scenario: Load page as authenticated user
     Given I am logged in as a user with the "content_creator" role
     And I am on "/"
     Then the response status code should be 200

  @api
   Scenario: Load page as authenticated user
     Given I am logged in as a user with the "administrator" role
     And I am on "/"
     Then the response status code should be 200

  #Scenario: Example table mapping role to specific permission string
    #Given the following roles have these permissions:
    #  | role            | permission |
    #  | content_creator | create basic_page content |

  
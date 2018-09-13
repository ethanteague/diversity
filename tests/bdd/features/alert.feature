@api @content
Feature: Alert Content Type Settings and Access

  Scenario: Roles have permission to act on Alert content.
    Given that only the following roles have content permissions for the "alert" content type:
      | role                    | permission |
      | content_creator	        | create     |
      | content_creator	        | edit own   |
      | content_creator	        | edit any   |
      | administrator	        | create     |
      | administrator	        | edit own   |
      | administrator	        | edit any   |
      | editor	                | create     |
      | editor	                | edit own   |
      | editor	                | edit any   |
      | publisher	                | create     |
      | publisher	                | edit own   |
      | publisher	                | edit any   |
      

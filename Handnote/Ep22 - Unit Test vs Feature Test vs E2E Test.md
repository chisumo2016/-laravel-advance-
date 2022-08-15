###  Unit Test vs Feature Test vs E2E Test
      Mantain  and Build the code is very harder , we alway need to test our code
      There are few way to archive this.
            1:Manual Testing - Developer goes through the code to check if its working
                                Not Realiable
                                Very slow
                                If add new feature , retest the all program .To make sure new feature doesnt break our code.
            2:Unit Testing  : testing a small block in the app ,we call FUNCTION,
                            To write all the function to our app.
                            Musst be faster to execute 
                            Is fasting , test small function in our app, very righ weight .
                                
            3:Feature Testing 
                    Testing the feature in the app.
                    Is higher level approach compare to Unit test
                    Faocus more features
                    More reliable 
                    Great
                    Slower than unit testing, depend on database operation or group of function run together .
            4:End to End Testing  (E2E) 
                    Higher level than Feature Testing
                    Test the app in mimics end user
                     Gold
                    Very Slow
           2-4 : Considered as automated testing
                    Developer will write the script to test an app.
                    Will have minimal minimum input .
      
          Unit testinng is notion of testing the smallest units/buildig blocks in our app .ie
            functions.If the building blocks are working, then the app should work.(this is not necessarily true)

          Featuring testing focusses on the feature and outcomeee rather than the individual functions.
            It is moore reliable that unit testing but slower.

         End-to-End testing mocks the end users' behaviour and has the highest reliability. However
            , E2E is very hard to impelement ad very slow .

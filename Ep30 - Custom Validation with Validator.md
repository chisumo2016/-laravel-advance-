### Custom Validation with Validator
    [X] We gonna use the validator instance facade instead of request
            $postCreated = $repository->create($request->only([
            'title',
            'body',
            'user_ids',
          ]));

        NOW
            public function store(Request $request, PostRepository $repository)
                {
                    $payLoad = $request->only([
                        'title',
                        'body',
                        'user_ids',
                    ]);
            
                    $validator = Validator::make($payLoad, [
                            'title'     => 'string|required',
                            'body'      => ['string','required'],
                            'user_ids'  => [
                                'array',
                                'required',
                                new InterArray(),
                        ]
                    ],
            
                    [
                        'body.required' => 'Please enter a value for body',
                        'title.string'  => 'Heyy use a string'
                    ],
                    [
                       'user_ids' =>"User IOOO"
                    ]);
            
                    $validator->validate();
                    $postCreated = $repository->create($payLoad);
            
                    return  new PostResource($postCreated);
                }
       [X] Provide more flexibility than request but Request class .This make our controller mess
       [X] Validator class  provides many methods
                errors()
                    $errors = $validator->errors();
                    dd($errors);
                $errors = $validator->errors();
                $errors = $validator->messsges();
                dd($validator->fails());
                dump($validator->passes());
                dd($validator->getData());
                dd($validator->attributes());

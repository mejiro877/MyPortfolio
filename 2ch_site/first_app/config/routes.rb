Rails.application.routes.draw do
   resources :boards do
     resources :comments, only: [:create, :destroy]
   end
 
   root to: 'boards#index'
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
end

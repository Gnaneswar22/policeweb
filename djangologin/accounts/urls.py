# accounts/urls.py

from django.urls import path
from .views import signup, login_view, home

urlpatterns = [
    path('signup/', signup, name='signup'),
    path('login/', login_view, name='login'),
    path('home/', home, name='home'),
]

# accounts/urls.py

from django.urls import path
from .views import signup, login_view, home, logout_view

urlpatterns = [
    path('signup/', signup, name='signup'),
    path('login/', login_view, name='login'),
    path('home/', home, name='home'),
    path('logout/', logout_view, name='logout'),  # Add this line
]

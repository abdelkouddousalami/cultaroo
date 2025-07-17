<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Culturoo - Experience Authentic Moroccan Culture</title>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --transition-smooth: cubic-bezier(0.23, 1, 0.32, 1);
            --transition-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
            --transition-spring: cubic-bezier(0.175, 0.885, 0.32, 1.275);
            --transition-out: cubic-bezier(0.55, 0.085, 0.68, 0.53);
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-moroccan {
            background: linear-gradient(135deg, #D2691E, #8B4513);
            transition: all 0.3s ease;
        }

        .btn-moroccan:hover {
            background: linear-gradient(135deg, #8B4513, #D2691E);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(139, 69, 19, 0.3);
        }

        .auth-container {
            height: 100vh;
            display: flex;
            position: relative;
            padding-top: 80px;
            /* Account for navbar */
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
            gap: 2rem;
            /* Add gap between form and image sides */
            transform: translateZ(0);
            will-change: auto;
            contain: layout style paint;
            box-sizing: border-box;
            overflow: hidden;
            align-items: center;
            /* Center both sides vertically */
            justify-content: center;
            /* Center both sides horizontally */
        }

        .auth-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            transition: all 1.6s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            height: calc(100vh - 80px);
            transform: translateZ(0);
            will-change: transform, opacity, filter, backdrop-filter;
            backface-visibility: hidden;
            perspective: 1000px;
            box-sizing: border-box;
        }

        .auth-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            /* Match form container dimensions exactly */
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            height: calc(100vh - 80px - 3rem);
            /* Take available height minus container padding */
            transition: all 1.4s cubic-bezier(0.23, 1, 0.32, 1);
            transform: translateX(0) translateY(0) rotateY(0deg) scale(1);
            will-change: transform, opacity, box-shadow;
            backface-visibility: hidden;
        }

        .image-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            transform: scale(1.1);
            transition: transform 1.8s cubic-bezier(0.23, 1, 0.32, 1), filter 1.2s ease-out;
            z-index: 1;
            will-change: transform, filter;
        }

        .image-side.transitioning::before {
            transform: scale(1.05) rotateZ(0.5deg);
            filter: brightness(1.1) contrast(1.1);
        }

        .login-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)),
            url('{{ asset("images/login.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .register-bg {
            background: linear-gradient(rgba(139, 69, 19, 0.3), rgba(210, 105, 30, 0.4)),
            url('{{ asset("images/register.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-container {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            width: 100%;
            max-width: 450px;
            height: calc(100vh - 80px - 3rem);
            /* Take available height minus container padding */
            position: relative;
            transition: all 1.4s cubic-bezier(0.23, 1, 0.32, 1);
            transform: translateX(0) translateY(0) rotateY(0deg) scale(1);
            opacity: 1;
            will-change: transform, opacity, box-shadow;
            transform-style: preserve-3d;
            backface-visibility: hidden;
            box-sizing: border-box;
            overflow: hidden;
            /* Remove scrolling from container, handled per form */
        }

        .form-container.slide-to-right {
            transform: translateX(120vw) translateY(-20px) rotateY(-8deg) scale(0.95);
            opacity: 0;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.15);
            transition: all 1.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .form-container.slide-to-left {
            transform: translateX(-120vw) translateY(-20px) rotateY(8deg) scale(0.95);
            opacity: 0;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.15);
            transition: all 1.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .form-container.slide-in-from-right {
            transform: translateX(0) translateY(0) rotateY(0deg) scale(1);
            opacity: 1;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 1.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .form-container.slide-in-from-left {
            transform: translateX(0) translateY(0) rotateY(0deg) scale(1);
            opacity: 1;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 1.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .image-side.slide-to-right {
            transform: translateX(120vw) translateY(-20px) rotateY(-8deg) scale(0.95);
            opacity: 0;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.15);
            transition: all 1.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .image-side.slide-to-left {
            transform: translateX(-120vw) translateY(-20px) rotateY(8deg) scale(0.95);
            opacity: 0;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.15);
            transition: all 1.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .image-side.slide-in-from-right {
            transform: translateX(0) translateY(0) rotateY(0deg) scale(1);
            opacity: 1;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 1.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .image-side.slide-in-from-left {
            transform: translateX(0) translateY(0) rotateY(0deg) scale(1);
            opacity: 1;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 1.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .image-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) translateZ(0);
            text-align: center;
            color: white;
            z-index: 3;
            padding: 2rem;
            transition: all 1.5s cubic-bezier(0.23, 1, 0.32, 1);
            opacity: 1;
            will-change: transform, opacity, filter;
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }

        .image-content.slide-to-left {
            transform: translate(-250%, -50%) translateZ(-50px) rotateX(5deg) rotateY(-15deg);
            opacity: 0;
            filter: blur(4px);
            transition: all 1.2s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        }

        .image-content.slide-to-right {
            transform: translate(150%, -50%) translateZ(-50px) rotateX(5deg) rotateY(15deg);
            opacity: 0;
            filter: blur(4px);
            transition: all 1.2s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        }

        .image-content.slide-in {
            transform: translate(-50%, -50%) translateZ(0) rotateX(0deg) rotateY(0deg);
            opacity: 1;
            filter: blur(0px);
            transition: all 1.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition-delay: 0.3s;
        }

        .image-content.fade-out {
            opacity: 0;
            transform: translate(-50%, -50%) translateZ(-30px) rotateX(-3deg) scale(0.98);
            filter: blur(2px);
            transition: all 0.6s cubic-bezier(0.55, 0.085, 0.68, 0.53);
        }

        .image-content.fade-in {
            opacity: 1;
            transform: translate(-50%, -50%) translateZ(0) rotateX(0deg) scale(1);
            filter: blur(0px);
            transition: all 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition-delay: 0.4s;
        }

        .image-content h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            transform: translateY(0);
            transition: transform 1.2s cubic-bezier(0.23, 1, 0.32, 1) 0.2s;
        }

        .image-content.slide-in h2 {
            transform: translateY(0);
            transition-delay: 0.6s;
        }

        .image-content.slide-to-left h2,
        .image-content.slide-to-right h2 {
            transform: translateY(-30px);
            transition: transform 0.8s cubic-bezier(0.55, 0.085, 0.68, 0.53);
        }

        .image-content p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 400px;
            margin: 0 auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            transform: translateY(0);
            transition: transform 1.2s cubic-bezier(0.23, 1, 0.32, 1) 0.4s;
        }

        .image-content.slide-in p {
            transform: translateY(0);
            transition-delay: 0.8s;
        }

        .image-content.slide-to-left p,
        .image-content.slide-to-right p {
            transform: translateY(20px);
            transition: transform 0.8s cubic-bezier(0.55, 0.085, 0.68, 0.53) 0.1s;
        }

        .form-switch {
            display: flex;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 1.5rem;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
            flex-shrink: 0;
        }

        .switch-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            color: #64748b;
            position: relative;
            z-index: 2;
            transform: scale(1);
        }

        .switch-btn:hover {
            transform: scale(1.02);
            color: #d97706;
        }

        .switch-btn.active {
            color: #d97706;
            transform: scale(1);
        }
        .regis{
            position: relative;
            top: -4rem;
        }

        .switch-indicator {
            position: absolute;
            top: 4px;
            left: 4px;
            height: calc(100% - 8px);
            width: calc(50% - 4px);
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.05);
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55), box-shadow 0.3s ease;
            z-index: 1;
            will-change: transform;
        }

        .switch-indicator:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.08);
        }

        .switch-indicator.register {
            transform: translateX(100%);
        }

        .form-content {
            position: relative;
            overflow: visible;
            /* Changed from hidden to visible to prevent clipping */
            height: 100%;
            /* Take full height of form container */
            display: flex;
            flex-direction: column;
            perspective: 1000px;
        }

        .auth-form {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: all 1.2s cubic-bezier(0.23, 1, 0.32, 1);
            opacity: 1;
            transform: translateX(0) translateZ(0) rotateY(0deg);
            will-change: transform, opacity;
            transform-style: preserve-3d;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding: 1rem 0;
            box-sizing: border-box;
        }

        .auth-form.slide-out-left {
            opacity: 0;
            transform: translateX(-120%) translateZ(-50px) rotateY(-15deg);
            pointer-events: none;
            transition: all 1.0s cubic-bezier(0.55, 0.085, 0.68, 0.53);
        }

        .auth-form.slide-out-right {
            opacity: 0;
            transform: translateX(120%) translateZ(-50px) rotateY(15deg);
            pointer-events: none;
            transition: all 1.0s cubic-bezier(0.55, 0.085, 0.68, 0.53);
        }

        /* Override for when forms should be immediately visible */
        .auth-form.slide-out-right.visible-form {
            opacity: 1;
            transform: translateX(0) translateZ(0) rotateY(0deg);
            pointer-events: all;
            transition: none;
        }

        .auth-form.slide-in-left {
            opacity: 1;
            transform: translateX(0) translateZ(0) rotateY(0deg);
            transition: all 1.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition-delay: 0.2s;
        }

        .auth-form.slide-in-right {
            opacity: 1;
            transform: translateX(0) translateZ(0) rotateY(0deg);
            transition: all 1.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition-delay: 0.2s;
        }

        .auth-form.preparing-slide-in {
            opacity: 0;
            transform: translateX(150%) translateZ(-30px) rotateY(10deg);
            transition: none;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        input,
        select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fafafa;
            transform: translateZ(0);
            will-change: transform, box-shadow;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #d97706;
            background: white;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        input:hover,
        select:hover {
            border-color: #d1d5db;
            background: white;
            transform: translateY(-0.5px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #d97706, #b45309);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 0.5rem;
            transform: translateZ(0);
            will-change: transform, box-shadow;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #b45309, #92400e);
            
            box-shadow: 0 12px 24px rgba(185, 83, 9, 0.4), 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:active {
            transform: translateY(-1px) scale(1.01);
            box-shadow: 0 6px 12px rgba(185, 83, 9, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            margin: 0.8rem 0;
        }

        .checkbox-group input {
            width: auto;
            margin-right: 0.5rem;
            margin-top: 2px;
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-weight: 400;
            color: #6b7280;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password a {
            color: #d97706;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Animation for sides switching */
        .auth-side.switching {
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Login form specific styling - no scroll */
        #loginForm {
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-start !important;
            overflow: hidden !important;
            padding: 0 !important;
        }

        #loginForm .form-group {
            margin-bottom: 1.2rem;
        }

        #loginForm .checkbox-group {
            margin: 1rem 0 0.5rem 0;
        }

        #loginForm .forgot-password {
            margin-top: 0.3rem;
            margin-bottom: 1rem;
        }

        #loginForm .btn-primary {
            margin-top: 0.5rem;
            flex-shrink: 0;
        }

        /* Register form - can scroll */
        #registerForm {
            overflow-y: auto !important;
            padding: 0.5rem 0 !important;
        }

        #registerForm .form-group {
            margin-bottom: 1rem;
        }

        /* Form layout within fixed height container */
        .form-switch {
            flex-shrink: 0;
            /* Don't shrink the switch tabs */
        }

        .auth-form .space-y-6 {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex-grow: 1;
            justify-content: center;
            min-height: 0;
            /* Allow flex items to shrink */
        }

        .auth-form .space-y-6> * {
            flex-shrink: 0;
        }

        /* Ensure submit button stays at bottom */
        .auth-form button[type="submit"] {
            margin-top: auto;
        }

        /* Ensure proper scrolling on smaller screens */
        @media (max-height: 700px) {
            .form-container {
                padding: 1rem;
            }

            .auth-form {
                padding: 0.5rem 0;
            }

            .auth-form .space-y-6 {
                gap: 0.75rem;
                justify-content: flex-start;
            }

            .form-switch {
                margin-bottom: 1rem;
            }
        }

        /* Additional responsive adjustments for very small screens */
        @media (max-height: 600px) {
            .auth-container {
                padding-top: 50px;
            }
            
            .form-container {
                max-height: calc(100vh - 50px - 2rem);
                padding: 1rem;
            }
            
            .image-side {
                height: calc(100vh - 50px - 2rem);
            }
            
            .auth-side {
                height: calc(100vh - 50px);
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                max-width: 100%;
                width: 100%;
                padding: 0;
                padding-top: 80px;
                gap: 0;
                align-items: stretch;
                justify-content: flex-start;
                min-height: 100vh;
                height: 100vh;
                background: #ffffff;
            }

            .auth-side,
            .form-container {
                max-width: 100%;
                width: 100%;
                height: auto;
                border-radius: 0;
                box-shadow: none;
            }

            /* Completely hide image side on mobile */
            .image-side,
            #rightSide {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                position: absolute !important;
                left: -9999px !important;
                width: 0 !important;
                height: 0 !important;
                overflow: hidden !important;
                z-index: -1 !important;
            }

            /* Only show left side with form container on mobile */
            #leftSide {
                width: 100% !important;
                height: calc(100vh - 80px) !important;
                display: flex !important;
                flex-direction: column !important;
                order: 1 !important;
            }

            .form-container {
                order: 1;
                width: 100% !important;
                height: calc(100vh - 80px) !important;
                max-height: calc(100vh - 80px) !important;
                padding: 1.5rem !important;
                overflow: hidden !important;
                background: #ffffff !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                margin: 0 !important;
            }
            .regis{
            position: relative;
            top: 0rem;
        }
            .image-content h2 {
                font-size: 2rem;
            }

            .image-content p {
                font-size: 1rem;
            }

            /* Mobile transitions - simpler */
            .auth-side.slide-to-left,
            .auth-side.slide-to-right,
            .form-container.slide-to-left,
            .form-container.slide-to-right {
                transform: translateY(-100vh) scale(0.9);
                opacity: 0;
            }

            .auth-side.slide-in-from-left,
            .auth-side.slide-in-from-right,
            .form-container.slide-in-from-left,
            .form-container.slide-in-from-right {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 480px) {
            .auth-container {
                max-width: 100%;
                padding: 0.5rem;
                padding-top: 90px;
                gap: 1rem;
            }

            .form-container {
                padding: 1rem;
                border-radius: 15px;
            }

            .image-side {
                border-radius: 15px;
                min-height: 250px;
            }

            .image-content h2 {
                font-size: 1.75rem;
            }

            .image-content p {
                font-size: 0.9rem;
                padding: 1rem;
            }
        }

        /* Mobile-only styles for new form classes */
        @media (max-width: 768px) {
            /* Force hide all forms by default on mobile */
            .mobile-login-form,
            .mobile-register-form {
                display: none !important;
            }
            
            /* Force show only the visible form on mobile */
            .mobile-login-form.visible-form,
            .mobile-register-form.visible-form {
                display: flex !important;
                position: relative !important;
                opacity: 1 !important;
                transform: none !important;
                top: auto !important;
                left: auto !important;
                right: auto !important;
                bottom: auto !important;
            }
            
            /* Override any conflicting classes on mobile */
            .auth-form.slide-out-left,
            .auth-form.slide-out-right,
            .auth-form.slide-in-left, 
            .auth-form.slide-in-right,
            .auth-form.preparing-slide-in {
                display: none !important;
            }
            
            .auth-form.slide-out-left.visible-form,
            .auth-form.slide-out-right.visible-form,
            .auth-form.slide-in-left.visible-form,
            .auth-form.slide-in-right.visible-form,
            .auth-form.preparing-slide-in.visible-form {
                display: flex !important;
                position: relative !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* Absolute mobile form control - highest specificity */
        @media (max-width: 768px) {
            .form-content .mobile-login-form:not(.visible-form),
            .form-content .mobile-register-form:not(.visible-form) {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                position: absolute !important;
                left: -9999px !important;
            }
            
            .form-content .mobile-login-form.visible-form,
            .form-content .mobile-register-form.visible-form {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: auto !important;
            }
        }
    </style>
</head>
<body class="font-['Inter'] text-gray-800 bg-orange-50">
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logos/cultaroo.svg') }}" alt="Culturoo" class="h-8 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="#experiences" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('our-book') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Our Book</a>
                    <a href="#about" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                    <span class="text-gray-700">Welcome, <span class="font-medium text-orange-600">{{ Auth::user()->first_name }}</span></span>
                    <span class="bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-2 py-1 rounded-full text-xs font-medium">
                        {{ Auth::user()->role_display }}
                    </span>
                    <a href="{{ route('profile') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Profile</a>
                    <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-moroccan text-white px-6 py-3 rounded-full font-medium">Logout</button>
                    </form>
                    @else
                    <!-- Hide Sign In and Join Now buttons on mobile -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('auth') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Sign In</a>
                        <a href="{{ route('auth') }}" class="btn-moroccan text-white px-6 py-3 rounded-full font-medium">Join Now</a>
                    </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-orange-600 focus:outline-none focus:text-orange-600" onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                    <a href="{{ route('welcome') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="#experiences" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="{{ route('listings.index') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('our-book') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Our Book</a>
                    <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        @auth
                        <div class="px-3 py-2">
                            <p class="text-sm text-gray-600">Welcome, <span class="font-medium text-orange-600">{{ Auth::user()->first_name }}</span></p>
                            <span class="inline-block bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-2 py-1 rounded-full text-xs font-medium mt-1">
                                {{ Auth::user()->role_display }}
                            </span>
                        </div>
                        <a href="{{ route('profile') }}" class="block px-3 py-2 text-orange-600 font-medium">Profile</a>
                        <form method="POST" action="{{ route('auth.logout') }}" class="px-3 mt-2">
                            @csrf
                            <button type="submit" class="w-full text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-full font-medium">Logout</button>
                        </form>
                        @else
                        <a href="{{ route('auth') }}" class="block px-3 py-2 text-orange-600 font-medium">Sign In</a>
                        <a href="{{ route('auth') }}" class="block mx-3 mt-2 text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-full font-medium">Join Now</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        </div>
    </nav>
    <div class="auth-container" id="authContainer">
        <!-- Left Side (Form for Login, Image for Register) -->
        <div class="auth-side" id="leftSide">
            <div class="form-container" id="formContainer">
                <div class="form-switch">
                    <div class="switch-indicator" id="switchIndicator"></div>
                    <button class="switch-btn active" id="loginTab">Sign In</button>
                    <button class="switch-btn" id="registerTab">Sign Up</button>
                </div>

                <div class="form-content">
                    <!-- Login Form -->
                    <form id="loginForm" class="auth-form mobile-login-form">
                        @csrf
                        <div class="form-group mobile-form-group">
                            <label for="loginEmail" class="mobile-form-label">Email Address</label>
                            <input type="email" id="loginEmail" name="email" required placeholder="Enter your email" class="mobile-form-input">
                        </div>

                        <div class="form-group mobile-form-group">
                            <label for="loginPassword" class="mobile-form-label">Password</label>
                            <div class="password-field mobile-password-field">
                                <input type="password" id="loginPassword" name="password" required placeholder="Enter your password" class="mobile-form-input">
                                <button type="button" class="password-toggle mobile-password-toggle" onclick="togglePassword('loginPassword')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="checkbox-group mobile-checkbox-group">
                            <input type="checkbox" id="remember" name="remember" class="mobile-checkbox">
                            <label for="remember" class="mobile-checkbox-label">Remember me</label>
                        </div>

                        <div class="forgot-password mobile-forgot-password">
                            <a href="#" class="mobile-forgot-link">Forgot your password?</a>
                        </div>

                        <button type="submit" class="btn-primary mobile-submit-btn">Sign In</button>
                    </form>

                    <!-- Register Form -->
                    <form id="registerForm" class="auth-form slide-out-right mobile-register-form">
                        @csrf
                        <div class="form-row mobile-form-row">
                            <div class="form-group mobile-form-group">
                                <label for="firstName" class="mobile-form-label">First Name</label>
                                <input type="text" id="firstName" name="first_name" required placeholder="First name" class="mobile-form-input">
                            </div>
                            <div class="form-group mobile-form-group">
                                <label for="lastName" class="mobile-form-label">Last Name</label>
                                <input type="text" id="lastName" name="last_name" required placeholder="Last name" class="mobile-form-input">
                            </div>
                        </div>

                        <div class="form-group mobile-form-group">
                            <label for="registerEmail" class="mobile-form-label">Email Address</label>
                            <input type="email" id="registerEmail" name="email" required placeholder="Enter your email" class="mobile-form-input">
                        </div>

                        <div class="form-group mobile-form-group">
                            <label for="registerPassword" class="mobile-form-label">Password</label>
                            <div class="password-field mobile-password-field">
                                <input type="password" id="registerPassword" name="password" required placeholder="Create a password" class="mobile-form-input">
                                <button type="button" class="password-toggle mobile-password-toggle" onclick="togglePassword('registerPassword')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-group mobile-form-group">
                            <label for="confirmPassword" class="mobile-form-label">Confirm Password</label>
                            <div class="password-field mobile-password-field">
                                <input type="password" id="confirmPassword" name="password_confirmation" required placeholder="Confirm your password" class="mobile-form-input">
                                <button type="button" class="password-toggle mobile-password-toggle" onclick="togglePassword('confirmPassword')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Hidden field to automatically set user type as traveler -->
                        <input type="hidden" name="user_type" value="traveler">

                        <div class="checkbox-group mobile-checkbox-group">
                            <input type="checkbox" id="terms" name="terms" required class="mobile-checkbox">
                            <label for="terms" class="mobile-checkbox-label">I agree to the <a href="#" style="color: #d97706; text-decoration: underline;">Terms of Service</a> and <a href="#" style="color: #d97706; text-decoration: underline;">Privacy Policy</a></label>
                        </div>

                        <button type="submit" class="btn-primary mobile-submit-btn regis">Create Account</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side (Image for Login, Form for Register) -->
        <div class="auth-side image-side login-bg" id="rightSide">
            <div class="image-content" id="imageContent">
                <h2>Welcome Back!</h2>
                <p>Sign in to continue your journey and discover authentic Moroccan experiences with local families.</p>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Global variables
        let currentForm = 'login';
        let isAnimating = false;
        let animationSequence = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Get all necessary elements
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const leftSide = document.getElementById('leftSide');
            const rightSide = document.getElementById('rightSide');
            const imageContent = document.getElementById('imageContent');
            const formContainer = document.getElementById('formContainer');
            const switchIndicator = document.getElementById('switchIndicator');

            // Animation sequence manager
            function createAnimationSequence(steps) {
                return {
                    steps: steps,
                    currentStep: 0,
                    execute: function() {
                        if (this.currentStep < this.steps.length) {
                            const step = this.steps[this.currentStep];
                            step.action();
                            this.currentStep++;
                            setTimeout(() => this.execute(), step.delay || 0);
                        }
                    },
                    reset: function() {
                        this.currentStep = 0;
                    }
                };
            }

            // Initialize form states
            function initializeForms() {
                const isMobile = window.innerWidth <= 768;
                
                if (isMobile) {
                    // Mobile initialization - explicitly set display styles
                    console.log('Mobile initialization - showing login form');
                    loginForm.style.display = 'flex';
                    loginForm.style.visibility = 'visible';
                    loginForm.style.opacity = '1';
                    loginForm.classList.add('visible-form');
                    
                    registerForm.style.display = 'none';
                    registerForm.style.visibility = 'hidden';
                    registerForm.style.opacity = '0';
                    registerForm.classList.remove('visible-form');
                    
                    // Clean up any desktop animation classes
                    [loginForm, registerForm].forEach(form => {
                        form.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-left', 'slide-in-right', 'preparing-slide-in');
                    });
                } else {
                    // Desktop initialization - reset inline styles
                    loginForm.style.display = '';
                    registerForm.style.display = '';
                    
                    loginForm.classList.remove('slide-out-left', 'slide-out-right', 'preparing-slide-in');
                    loginForm.classList.add('visible-form');
                    registerForm.classList.remove('slide-in-left', 'slide-in-right', 'preparing-slide-in', 'visible-form');
                    registerForm.classList.add('slide-out-right');
                }

                // Reset any transition states
                leftSide.classList.remove('transitioning', 'slide-to-left', 'slide-to-right', 'slide-in-from-left', 'slide-in-from-right');
                rightSide.classList.remove('transitioning', 'slide-to-left', 'slide-to-right', 'slide-in-from-left', 'slide-in-from-right');
                formContainer.classList.remove('slide-to-left', 'slide-to-right', 'slide-in-from-left', 'slide-in-from-right');
                imageContent.classList.remove('fade-out', 'fade-in', 'slide-to-left', 'slide-to-right', 'slide-in');
            }

            // Initialize on page load
            initializeForms();

            function switchToLogin() {
                if (isAnimating || currentForm === 'login') return;
                isAnimating = true;
                currentForm = 'login';

                // Check if mobile
                const isMobile = window.innerWidth <= 768;
                
                if (isMobile) {
                    // Mobile: immediately switch forms
                    console.log('Mobile switch to login');
                    loginForm.style.display = 'flex';
                    loginForm.style.visibility = 'visible';
                    loginForm.style.opacity = '1';
                    loginForm.classList.add('visible-form');
                    
                    registerForm.style.display = 'none';
                    registerForm.style.visibility = 'hidden';
                    registerForm.style.opacity = '0';
                    registerForm.classList.remove('visible-form');
                    
                    currentForm = 'login';
                    loginTab.classList.add('active');
                    registerTab.classList.remove('active');
                    switchIndicator.classList.remove('register');
                    return;
                }

                // Desktop animation code
                // Add animating class to prevent interruptions
                document.getElementById('authContainer').classList.add('animating');

                // Update tab appearance
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                switchIndicator.classList.remove('register');

                // Clear any existing animations
                if (animationSequence) animationSequence.reset();

                // Create and execute animation sequence
                animationSequence = createAnimationSequence([{
                        action: () => {
                            // Start transition states
                            leftSide.classList.add('transitioning');
                            rightSide.classList.add('transitioning');
                            imageContent.classList.add('fade-out');
                        },
                        delay: 0
                    },
                    {
                        action: () => {
                            // Start form and container animations
                            formContainer.classList.add('slide-to-left');
                            registerForm.classList.add('slide-out-left');
                            loginForm.classList.add('preparing-slide-in');
                            // Add image-side animation
                            rightSide.classList.add('slide-to-left');
                        },
                        delay: 100
                    },
                    {
                        action: () => {
                            // Start image content slide
                            imageContent.classList.add('slide-to-left');
                        },
                        delay: 200
                    },
                    {
                        action: () => {
                            // Switch layout and reset positions
                            leftSide.className = 'auth-side transitioning';
                            rightSide.className = 'auth-side image-side login-bg transitioning';

                            // Move elements to correct sides
                            if (!leftSide.contains(formContainer)) {
                                leftSide.appendChild(formContainer);
                            }

                            if (!rightSide.contains(imageContent)) {
                                rightSide.appendChild(imageContent);
                            }

                            // Reset form states properly
                            registerForm.classList.remove('slide-in-left', 'preparing-slide-in');
                            registerForm.classList.add('slide-out-right');
                            loginForm.classList.remove('slide-out-right', 'slide-in-right');

                            // Update image content
                            imageContent.innerHTML = `
                                <h2>Welcome Back!</h2>
                                <p>Sign in to continue your journey and discover authentic Moroccan experiences with local families.</p>
                            `;
                        },
                        delay: 600
                    },
                    {
                        action: () => {
                            // Reset form container position
                            formContainer.classList.remove('slide-to-left');
                            formContainer.classList.add('slide-in-from-left');

                            // Reset image content
                            imageContent.classList.remove('fade-out', 'slide-to-left');
                            imageContent.classList.add('fade-in');

                            // Reset image-side position
                            rightSide.classList.remove('slide-to-left');
                            rightSide.classList.add('slide-in-from-left');
                        },
                        delay: 100
                    },
                    {
                        action: () => {
                            // Bring in the login form
                            loginForm.classList.remove('preparing-slide-in');
                            loginForm.classList.add('slide-in-right');
                        },
                        delay: 300
                    },
                    {
                        action: () => {
                            // Clean up all animation classes
                            leftSide.classList.remove('transitioning');
                            rightSide.classList.remove('transitioning', 'slide-in-from-left');
                            formContainer.classList.remove('slide-in-from-left');
                            imageContent.classList.remove('fade-in');
                            registerForm.classList.remove('slide-out-left', 'preparing-slide-in', 'visible-form');
                            loginForm.classList.remove('slide-in-right', 'preparing-slide-in');

                            // Ensure correct form visibility for login state
                            registerForm.classList.add('slide-out-right');
                            loginForm.classList.remove('slide-out-right', 'slide-out-left');
                            loginForm.classList.add('visible-form');

                            document.getElementById('authContainer').classList.remove('animating');
                            isAnimating = false;
                        },
                        delay: 1800
                    }
                ]);

                animationSequence.execute();
            }

            function switchToRegister() {
                if (isAnimating || currentForm === 'register') return;
                isAnimating = true;
                currentForm = 'register';

                // Check if mobile
                const isMobile = window.innerWidth <= 768;
                
                if (isMobile) {
                    // Mobile transition - explicitly hide login form and show register form
                    console.log('Mobile switch to register - hiding login, showing register');
                    loginForm.style.display = 'none';
                    loginForm.style.visibility = 'hidden';
                    loginForm.style.opacity = '0';
                    loginForm.classList.remove('visible-form');
                    
                    registerForm.style.display = 'flex';
                    registerForm.style.visibility = 'visible';
                    registerForm.style.opacity = '1';
                    registerForm.classList.add('visible-form');
                    
                    // Update tab states
                    registerTab.classList.add('active');
                    loginTab.classList.remove('active');
                    switchIndicator.classList.add('register');
                    
                    // Reset scroll position
                    setTimeout(() => {
                        registerForm.scrollTop = 0;
                    }, 10);
                    
                    isAnimating = false;
                    return;
                }

                // Desktop animation code
                // Add animating class to prevent interruptions
                document.getElementById('authContainer').classList.add('animating');

                // Update tab appearance
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                switchIndicator.classList.add('register');

                // Clear any existing animations
                if (animationSequence) animationSequence.reset();

                // Create and execute animation sequence
                animationSequence = createAnimationSequence([{
                        action: () => {
                            // Start transition states
                            leftSide.classList.add('transitioning');
                            rightSide.classList.add('transitioning');
                            imageContent.classList.add('fade-out');
                        },
                        delay: 0
                    },
                    {
                        action: () => {
                            // Start form and container animations
                            formContainer.classList.add('slide-to-right');
                            loginForm.classList.add('slide-out-right');
                            registerForm.classList.add('preparing-slide-in');
                            // Add image-side animation
                            leftSide.classList.add('slide-to-right');
                        },
                        delay: 100
                    },
                    {
                        action: () => {
                            // Start image content slide
                            imageContent.classList.add('slide-to-right');
                        },
                        delay: 200
                    },
                    {
                        action: () => {
                            // Switch layout: image on left, form on right
                            leftSide.className = 'auth-side image-side register-bg transitioning';
                            rightSide.className = 'auth-side transitioning';

                            // Move elements to correct sides
                            if (!rightSide.contains(formContainer)) {
                                rightSide.appendChild(formContainer);
                            }

                            if (!leftSide.contains(imageContent)) {
                                leftSide.appendChild(imageContent);
                            }

                            // Reset form states properly
                            loginForm.classList.remove('slide-in-right', 'preparing-slide-in');
                            loginForm.classList.add('slide-out-left');
                            registerForm.classList.remove('slide-out-left', 'slide-in-left');

                            // Update image content
                            imageContent.innerHTML = `
                                <h2>Join Our Community!</h2>
                                <p>Create your account and start exploring authentic Moroccan culture with welcoming host families.</p>
                            `;
                        },
                        delay: 600
                    },
                    {
                        action: () => {
                            // Reset form container position
                            formContainer.classList.remove('slide-to-right');
                            formContainer.classList.add('slide-in-from-right');

                            // Reset image content
                            imageContent.classList.remove('fade-out', 'slide-to-right');
                            imageContent.classList.add('fade-in');

                            // Reset image-side position
                            leftSide.classList.remove('slide-to-right');
                            leftSide.classList.add('slide-in-from-right');
                        },
                        delay: 100
                    },
                    {
                        action: () => {
                            // Bring in the register form
                            registerForm.classList.remove('preparing-slide-in');
                            registerForm.classList.add('slide-in-left');
                        },
                        delay: 300
                    },
                    {
                        action: () => {
                            // Clean up all animation classes
                            leftSide.classList.remove('transitioning', 'slide-in-from-right');
                            rightSide.classList.remove('transitioning');
                            formContainer.classList.remove('slide-in-from-right');
                            imageContent.classList.remove('fade-in');
                            loginForm.classList.remove('slide-out-right', 'preparing-slide-in', 'visible-form');
                            registerForm.classList.remove('slide-in-left', 'preparing-slide-in');

                            // Ensure correct form visibility for register state
                            loginForm.classList.add('slide-out-left');
                            registerForm.classList.remove('slide-out-right', 'slide-out-left');
                            registerForm.classList.add('visible-form');

                            document.getElementById('authContainer').classList.remove('animating');
                            isAnimating = false;
                        },
                        delay: 1800
                    }
                ]);

                animationSequence.execute();
            }

            // Add event listeners with debouncing
            if (loginTab && registerTab) {
                let tabClickTimeout;

                loginTab.addEventListener('click', function() {
                    clearTimeout(tabClickTimeout);
                    
                    // Check if mobile for immediate form switching
                    const isMobile = window.innerWidth <= 768;
                    
                    if (isMobile && currentForm !== 'login') {
                        // Mobile: immediately switch forms
                        console.log('Mobile switch to login');
                        loginForm.style.display = 'flex';
                        loginForm.style.visibility = 'visible';
                        loginForm.style.opacity = '1';
                        loginForm.classList.add('visible-form');
                        
                        registerForm.style.display = 'none';
                        registerForm.style.visibility = 'hidden';
                        registerForm.style.opacity = '0';
                        registerForm.classList.remove('visible-form');
                        
                        currentForm = 'login';
                        loginTab.classList.add('active');
                        registerTab.classList.remove('active');
                        switchIndicator.classList.remove('register');
                        return;
                    }
                    
                    tabClickTimeout = setTimeout(switchToLogin, 50);
                });

                registerTab.addEventListener('click', function() {
                    clearTimeout(tabClickTimeout);
                    
                    // Check if mobile for immediate form switching
                    const isMobile = window.innerWidth <= 768;
                    
                    if (isMobile && currentForm !== 'register') {
                        // Mobile: immediately switch forms
                        console.log('Mobile switch to register');
                        registerForm.style.display = 'flex';
                        registerForm.style.visibility = 'visible';
                        registerForm.style.opacity = '1';
                        registerForm.classList.add('visible-form');
                        
                        loginForm.style.display = 'none';
                        loginForm.style.visibility = 'hidden';
                        loginForm.style.opacity = '0';
                        loginForm.classList.remove('visible-form');
                        
                        currentForm = 'register';
                        registerTab.classList.add('active');
                        loginTab.classList.remove('active');
                        switchIndicator.classList.add('register');
                        return;
                    }
                    
                    tabClickTimeout = setTimeout(switchToRegister, 50);
                });

                // Add ripple effect to tabs
                [loginTab, registerTab].forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        const ripple = document.createElement('span');
                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        const x = e.clientX - rect.left - size / 2;
                        const y = e.clientY - rect.top - size / 2;

                        ripple.style.cssText = `
                            position: absolute;
                            width: ${size}px;
                            height: ${size}px;
                            left: ${x}px;
                            top: ${y}px;
                            background: rgba(217, 119, 6, 0.2);
                            border-radius: 50%;
                            transform: scale(0);
                            animation: ripple 0.6s ease-out;
                            pointer-events: none;
                        `;

                        this.style.position = 'relative';
                        this.style.overflow = 'hidden';
                        this.appendChild(ripple);

                        setTimeout(() => ripple.remove(), 600);
                    });
                });
            }

            // Add CSS animation for ripple effect
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
                
                .auth-container.animating {
                    pointer-events: none;
                }
                
                .auth-container.animating .form-switch {
                    pointer-events: all;
                }
            `;
            document.head.appendChild(style);

            // Login form handler
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;

                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Signing In...';

                    fetch('{{ route("auth.login") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect || '{{ route("profile") }}';
                        } else {
                            alert(data.message || 'Login failed. Please try again.');
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Login error:', error);
                        alert('An error occurred. Please try again.');
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
                });
            }

            // Register form handler
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;

                    // Validate password confirmation
                    const password = formData.get('password');
                    const confirmPassword = formData.get('password_confirmation');
                    
                    if (password !== confirmPassword) {
                        alert('Passwords do not match.');
                        return;
                    }

                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Creating Account...';

                    fetch('{{ route("auth.register") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Redirect to OTP verification page
                            window.location.href = data.redirect;
                        } else {
                            if (data.errors) {
                                let errorMessage = '';
                                Object.values(data.errors).forEach(errors => {
                                    errors.forEach(error => {
                                        errorMessage += error + '\n';
                                    });
                                });
                                alert(errorMessage);
                            } else {
                                alert(data.message || 'Registration failed. Please try again.');
                            }
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Registration error:', error);
                        alert('An error occurred. Please try again.');
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
                });
            }
        });

        // Password toggle functionality
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }

        function showMessage(message, type) {
            // Remove existing messages
            const existingMessages = document.querySelectorAll('.message-alert');
            existingMessages.forEach(msg => msg.remove());

            // Create message element
            const messageEl = document.createElement('div');
            messageEl.className = `message-alert fixed top-24 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
                type === 'success' 
                    ? 'bg-green-100 text-green-800 border border-green-200' 
                    : 'bg-red-100 text-red-800 border border-red-200'
            }`;
            messageEl.textContent = message;

            // Add to body
            document.body.appendChild(messageEl);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (messageEl && messageEl.parentNode) {
                    messageEl.style.opacity = '0';
                    messageEl.style.transform = 'translateX(100%)';
                    setTimeout(() => messageEl.remove(), 300);
                }
            }, 5000);
        }

        // Navigation background on scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('bg-white/98');
                nav.classList.remove('bg-white/95');
            } else {
                nav.classList.add('bg-white/95');
                nav.classList.remove('bg-white/98');
            }
        });

        // Handle window resize for responsive behavior
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const isMobile = window.innerWidth <= 768;
                const authContainer = document.getElementById('authContainer');
                
                if (isMobile) {
                    // Reset any desktop animations and ensure proper mobile state
                    authContainer.classList.remove('animating');
                    isAnimating = false;
                    
                    // Explicitly set display styles based on current state
                    if (currentForm === 'login') {
                        loginForm.style.display = 'flex';
                        loginForm.classList.add('visible-form');
                        registerForm.style.display = 'none';
                        registerForm.classList.remove('visible-form');
                    } else {
                        registerForm.style.display = 'flex';
                        registerForm.classList.add('visible-form');
                        loginForm.style.display = 'none';
                        loginForm.classList.remove('visible-form');
                    }
                    
                    // Clean up any animation classes
                    [loginForm, registerForm].forEach(form => {
                        form.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-left', 'slide-in-right', 'preparing-slide-in');
                    });
                } else {
                    // Reset inline styles for desktop
                    loginForm.style.display = '';
                    registerForm.style.display = '';
                }
            }, 100);
        });
    </script>
    </body>

</html>
<style>
        .centered-box {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }
        
        /* CSS styles for modal (same as before) */
        .dark-skin .modal-fill .modal-content {
            background-color: #172b4c;
        }
        .dark-skin .modal.modal-fill {
            background-color: #172b4c;
        }
        .modal-fill {
            background: rgba(255, 255, 255, 0.97);
            -webkit-transform: scale(0, 0);
            transform: scale(0, 0);
            -webkit-transition: .4s;
            transition: .4s;
        }
        .modal-fill.show {
            display: -webkit-box !important;
            display: flex !important;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-flow: column nowrap;
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            -webkit-transition: .4s;
            transition: .4s;
        }
        .modal-fill .modal-dialog {
            display: -webkit-box;
            display: flex;
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-flow: column nowrap;
            align-content: center;
            -webkit-box-align: center;
            align-items: center;
        }
        .modal-fill .modal-content {
            background: rgba(255, 255, 255, 0.97);
            width: 100%;
            max-width: 600px;
            box-shadow: none;
        }
        .modal-fill .modal-header {
            border-bottom: none;
        }
        .modal-fill .modal-header .close {
            position: fixed;
            top: 0;
            right: 0;
            padding: 20px;
            font-size: 2.5714285714rem;
            font-weight: 300;
        }
        .modal-fill .modal-footer {
            border: none;
        }
        .modal {
            background: rgba(0, 0, 0, 0.3);
        }
        .modal.modal-fill {
            background: rgba(255, 255, 255, 0.97);
        }
    </style>
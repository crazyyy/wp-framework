pipeline {
    agent any

    environment {
        DEPLOY_PATH = "/var/www/html"
        REPO_PATH   = "/srv/www/wordpress-blog"
        BASTION_USERNAME = credentials('BASTION_USERNAME') 
        BASTION_HOST = credentials('BASTION_HOST') 
        USERNAME = credentials('USERNAME') 
        HOST = credentials('HOST')
        SSH_CREDENTIALS = 'SSH_CREDENTIALS'
    }
    triggers {
        githubPush()
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('Redeploy WordPress') {
            steps {
                script {
                    // Use SSH agent for git
                    withCredentials([sshUserPrivateKey(credentialsId: "${SSH_CREDENTIALS}", keyFileVariable: 'KEYFILE')]) {
                        sh "ssh-keyscan ${BASTION_HOST} >> ~/.ssh/known_hosts"
                        sh """
                        ssh -i $KEYFILE -o StrictHostKeyChecking=no -J ${BASTION_USERNAME}@${BASTION_HOST} ${USERNAME}@${HOST} 'sudo git -C ${REPO_PATH} pull && \
                        sudo rsync -avz ${REPO_PATH}/ ${DEPLOY_PATH}/ && \
                        sudo chown -R www-data:www-data ${DEPLOY_PATH}'
                        """
                    }
                }
            }
        }
    }

    post {
        success {
            echo "Deployment successful!"
        }
        failure {
            echo "Deployment failed!"
        }
    }
}

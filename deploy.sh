#!/bin/bash

echo "📦 Building assets..."
npm run build

echo "🚀 Uploading build folder to EC2..."
scp -r public/build/ ubuntu@http://13.210.72.244:/var/www/html/your-project/public/

echo "✅ Deployment complete!"


###################################################################################
###################################################################################

# Jadikan Script Bisa Dieksekusi
# chmod +x deploy.sh

# Jalankan Script-nya
# Setiap kali kamu mau update CSS/JS ke server:
# ./deploy.sh

###################################################################################
###################################################################################
targetScope = 'resourceGroup'

@allowed([
  'dev'
  'prod'
])
param environment string

param location string = resourceGroup().location

@minLength(5)
param acrName string

param logAnalyticsName string
param containerAppsEnvName string

param apiAppName string
param frontendAppImage string

param apiImage string
param frontendImage string

@secure()
param appSecret string

@secure()
param databaseUrl string

param corsAllowOrigin string
param defaultUri string

module acr './modules/acr.bicep' ={
  name: 'acr'
  params: {
    name: acrName
    location: location
  }
}

module logAnalytics './modules/log-analytics.bicep' = {
   name: 'logAnalytics'
   params: {
      name: logAnalyticsName
      location: location
   }
}

module containerApps './modules/container-apps.bicep' = {
  name: 'containerApps'
  params: {
    location: location
    environment: environment

    containerAppsEnvName: containerAppsEnvName

    apiAppName: apiAppName
    frontendAppName: frontendAppImage

    logAnalyticsCustomerId: logAnalytics.outputs.customerId
    logAnalyticsSharedKey: logAnalytics.outputs.sharedKey

    registryServer: acr.outputs.loginServer
    registryUsername: acr.outputs.username
    registryPassword: acr.outputs.password

    apiImage: apiImage
    frontendImage: frontendImage

    appSecret: appSecret
    databaseUrl: databaseUrl

    corsAllowOrigin: corsAllowOrigin
    defaultUri: defaultUri
  }
}

output apiUrl string = containerApps.outputs.apiUrl
output frontendUrl string = containerApps.outputs.frontendUrl

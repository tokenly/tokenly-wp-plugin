import 'reflect-metadata'
import { Container, interfaces } from 'inversify'
import { TYPES } from '../Types'
import bindCommonDependencies from '../Inversify.config'

import AdminRouter from './Routes/AdminRouter'
import AdminRouterInterface from './Interfaces/Routes/AdminRouterInterface'
import { ethers } from "ethers"

declare const window: any

const container = new Container()
bindCommonDependencies( container )
container.bind<AdminRouterInterface>(
    TYPES.Routes.AdminRouterInterface
).to( AdminRouter )

container.bind<ethers.providers.Web3Provider>(
    TYPES.Variables.web3Provider
)
.toDynamicValue( ( context: interfaces.Context ) => {
    return new ethers.providers.Web3Provider( window.ethereum )
} )
.inSingletonScope()

export { container }

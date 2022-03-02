import 'reflect-metadata';
import { Container, interfaces } from 'inversify';
import { TYPES } from '../Types';
import bindCommonDependencies from '../Inversify.config';

import AdminRouter from './Routes/AdminRouter';
import AdminRouterInterface from './Interfaces/Routes/AdminRouterInterface';

const container = new Container();
bindCommonDependencies( container );
container.bind<AdminRouterInterface>( TYPES.Routes.AdminRouterInterface ).to( AdminRouter );

export { container };

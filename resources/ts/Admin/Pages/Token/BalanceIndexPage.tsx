import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import Preloader from '../../Components/Preloader';
import BalanceList from '../../Components/Token/BalanceList';
import UserRepositoryInterface from '../../../Interfaces/Repositories/UserRepositoryInterface';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import BalanceRepositoryInterface from '../../../Interfaces/Repositories/Token/BalanceRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

interface BalanceIndexPageData {
	//
}

interface BalanceIndexPageProps {
	pageData: BalanceIndexPageData;
}

interface BalanceIndexPageState {
	balance: any;
	loadingAddress: boolean;
	loadingBalance: boolean;
	loadingUser: boolean;
	address_id: string;
	address: any;
	user_id: string;
	user: any;
}

export default class BalanceIndexPage extends Component<BalanceIndexPageProps, BalanceIndexPageState> {
	@resolve( TYPES.Repositories.Token.BalanceRepositoryInterface )
	balanceRepository: BalanceRepositoryInterface;
	@resolve( TYPES.Repositories.Token.AddressRepositoryInterface )
	addressRepository: AddressRepositoryInterface;
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;

	state: BalanceIndexPageState = {
		balance: null,
		loadingAddress: false,
		loadingBalance: false,
		loadingUser: false,
		address_id: null,
		address: null,
		user_id: null,
		user: null,
	}
	constructor( props: BalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.address = urlParams.get( 'address' );
		this.state.user = urlParams.get( 'user' );
	}

	componentWillMount() {
		const params = {
			...( this.state.address ) && { address: this.state.address },
			...( this.state.user ) && { user: this.state.user },
		}
		this.setState( { loadingBalance: true } );
		this.balanceRepository.index( params ).then( ( balance: any ) => {
			this.setState( {
				loadingBalance: false,
				balance: balance,
			} );
		} );
		if ( this.state.address ) {
			this.setState( { loadingAddress: true } );
			this.addressRepository.show( this.state.address ).then( ( address: any ) => {
				this.setState( {
					loadingAddress: false,
					address: address,
				} );
			} );
		}
		if ( this.state.user ) {
			this.setState( { loadingUser: true } );
			this.userRepository.show( this.state.user ).then( ( address: any ) => {
				this.setState( {
					loadingUser: false,
					user: user,
				} );
			} );
		}
	}
	
	render() {
		return (
			<Page title={'Token balance listing'}>
			{ this.state.user &&
				<Panel header="User info">
					<PanelBody>
						<Preloader loading={ this.state.loadingUser } label="user" />
					{ !this.state.loadingUser &&
						<Flex></Flex>
					}
					</PanelBody>
				</Panel>
			}
			{ this.state.address &&
				<Panel header="Address info">
					<PanelBody>
						<Preloader loading={ this.state.loadingAddress } label="address" />
					{ !this.state.loadingAddress &&
						<Flex></Flex>
					}
					</PanelBody>
				</Panel>
			}
				<Panel header="Token listing">
					<PanelBody>
						<PanelRow>
							<Flex>
								<Preloader loading={ this.state.loadingBalance } label="balance" />
							{ !this.state.loadingBalance &&
								<Flex style={ { width: '100%' } } >
									<div style={ { marginBottom: '12px' } }>
										{/* Owner ({ this.props.pageData.entity.type }): <strong>{ this.props.pageData.entity.name }</strong> */}
									</div>
									<BalanceList balance={ this.state?.balance ?? [] } />
								</Flex>
							}
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}

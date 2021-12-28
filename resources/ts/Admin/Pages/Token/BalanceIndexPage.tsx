import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import BalanceList from '../../Components/Token/BalanceList';
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
	loading: boolean;
	address: string;
	user: string;
}

export default class BalanceIndexPage extends Component<BalanceIndexPageProps, BalanceIndexPageState> {
	@resolve( TYPES.Repositories.Token.BalanceRepositoryInterface )
	balanceRepository: BalanceRepositoryInterface;

	state: BalanceIndexPageState = {
		balance: null,
		loading: false,
		address: null,
		user: null,
	}
	constructor( props: BalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.address = urlParams.get( 'address' );
		this.state.user = urlParams.get( 'user' );
	}

	componentWillMount() {
		this.setState( { loading: true } );
		const params = {
			...( this.state.address ) && { address: this.state.address },
			...( this.state.user ) && { user: this.state.user },
		}
		this.balanceRepository.index( params ).then( ( balance: any ) => {
			this.setState( {
				loading: false,
				balance: balance,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Token balance listing'}>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-token-source-index'>To source list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.state.loading
								?	<Flex justify="flex-start">
										<span>Loading balance ... </span>
										<Spinner />
									</Flex>
								:	<Flex style={ { width: '100%' } } >
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

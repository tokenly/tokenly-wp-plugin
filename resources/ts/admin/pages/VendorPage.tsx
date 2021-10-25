import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { VendorRepository, VendorData } from '../../repositories/VendorRepository';

declare const wp: any;

const { __ } = wp.i18n;

const {
	Button,
	Spinner,
	ComboboxControl,
	TextControl,
	TextareaControl,
	Panel,
	PanelBody,
	PanelRow,
} = wp.components;

interface VendorPageData {
	//
}

interface VendorPageProps {
	pageData: VendorPageData;
	saving: boolean;
}

interface User {
	name: string;
	id: number;
}

interface VendorPageState {
	vendorData: VendorData;
	userSearch: string;
	users: Array<User>;
}

export default class VendorPage extends Component<VendorPageProps, VendorPageState> {
	@resolve
	vendorRepository: VendorRepository;
	
	state: VendorPageState = {
		vendorData: {
			//
		},
		userSearch: '',
		users: [],
	}
	constructor( props: VendorPageProps ) {
		super( props );
		this.onUserSearch = this.onUserSearch.bind( this );
	}
	
	componentDidMount() {
		this.vendorRepository.read().then( ( vendorData: VendorData ) => {
			this.setState( {
				vendorData: vendorData,
			} );
		} );
	}
	
	onUserSearch( keywords: string ) {
		
	}
	
	onUserSelect( username: string ) {
		
	}
	
	onPromiseSubmit() {
		//
	}
	
	render() {
		return (
			<Page title={'Tokenpass Vendor'}>
				<Panel header="Create transaction">
					<PanelBody>
						<PanelRow>
						<ComboboxControl
							label="Destination user"
							onChange={ (value: any) => {} }
							options={ this.state.users }
							onFilterValueChange={ ( keywords: string ) => {
								this.onUserSearch( keywords );
							} }
						/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Asset ID"
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Quantity"
								type="number"
								value={ 1 }
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Ref"
							/>
						</PanelRow>
						<PanelRow>
							<TextareaControl
								label="Note"
							/>
						</PanelRow>
						<PanelRow>
							<Button
								isPrimary
								isLarge
								disabled={ this.props.saving }
								onClick={ () => {
									this.onPromiseSubmit();
								}}
							>
								{ __( 'Create transaction' ) }
							</Button>
							{this.props.saving === true &&
									<Spinner/>
							}
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}

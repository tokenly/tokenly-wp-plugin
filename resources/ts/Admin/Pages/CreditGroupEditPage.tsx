import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { CreditGroupRepositoryInterface } from '../../Interfaces/Repositories/CreditGroupRepositoryInterface';
import { CreditGroupEditForm } from '../Components/CreditGroupEditForm';
import { TYPES } from '../../Types';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

declare const window: any;

interface CreditGroupEditPageData {
	credit_group: any;
}

interface CreditGroupEditPageProps {
	pageData: CreditGroupEditPageData;
}

interface CreditGroupEditPageState {
	saving: boolean;
}

export default class CreditGroupEditPage extends Component<CreditGroupEditPageProps, CreditGroupEditPageState> {
	@resolve( TYPES.CreditGroupRepositoryInterface )
	creditGroupRepository: CreditGroupRepositoryInterface;
	
	state: CreditGroupEditPageState = {
		saving: false,
	}

	constructor( props: CreditGroupEditPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onCancel = this.onCancel.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
	}

	onSave( creditGroup: any ) {
		this.setState( { saving: true } );
		let updateParams = Object.assign( {}, creditGroup );
		updateParams.uuid = this.props.pageData.credit_group.uuid;
		this.creditGroupRepository.update( updateParams ).then( ( result: any ) => {
			this.setState( { saving: false } );
			this.return();
		});
	}

	onCancel() {
		this.return();
	}
	
	render() {
		return (
			<Page title={ 'Manage credit group' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to credit group list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<div>
								<div>
									<CreditGroupEditForm
										onSave={ this.onSave }
										onCancel={ this.onCancel }
										saving={ this.state.saving }
										creditGroup={ this.props.pageData.credit_group }
									/>
								</div>
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}